<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Booking;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        Booking::autoCancelExpired();

        $books = Book::with("category")
            ->when($request->q, fn ($q) => $q->search($request->q))
            ->when($request->category_id, fn ($q) => $q->where("category_id", $request->category_id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy("name")->get();

        return view("admin.books.index", compact("books", "categories"));
    }

    public function create()
    {
        $categories = Category::orderBy("name")->get();
        return view("admin.books.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $validated = $this->validateBook($request);
        $validated = $this->applyCoverUpload($request, $validated);

        Book::create($validated);

        return redirect()->route("admin.books.index")->with("success", "Buku berhasil ditambahkan.");
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy("name")->get();
        return view("admin.books.edit", compact("book", "categories"));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $this->validateBook($request, $book->id);
        $validated = $this->applyCoverUpload($request, $validated);

        // Kalau nama file cover dikosongkan dan tidak ada upload baru,
        // pertahankan cover lama supaya tidak terhapus tanpa sengaja.
        if (array_key_exists("cover", $validated) && $validated["cover"] === null) {
            unset($validated["cover"]);
        }

        $book->update($validated);

        return redirect()->route("admin.books.index")->with("success", "Data buku berhasil diperbarui.");
    }

    public function destroy(Book $book)
    {
        if ($book->transactions()->whereIn("status", ["dipinjam", "terlambat"])->exists()) {
            return back()->with("error", "Buku tidak dapat dihapus karena masih ada transaksi peminjaman aktif.");
        }

        $book->delete();

        return redirect()->route("admin.books.index")->with("success", "Buku berhasil dihapus.");
    }

    /**
     * Upload cover langsung dari form admin.
     * - File disimpan ke public/images/books/<slug-kategori>/
     * - Kolom "cover" diisi nama filenya, jadi cara lama (upload lewat VS Code
     *   lalu ketik nama file) tetap bisa dipakai.
     * - Kalau tidak ada file yang diupload, nilai kolom cover dibiarkan apa adanya.
     */
    private function applyCoverUpload(Request $request, array $validated): array
    {
        unset($validated["cover_file"]);

        // File bisa datang dari input "cover_file" (baru) atau "cover" (jika form lama masih input file)
        $file = $request->file("cover_file");
        if (! $file && $request->hasFile("cover")) {
            $file = $request->file("cover");
        }

        if (! $file) {
            return $validated;
        }

        $category = Category::find($validated["category_id"] ?? $request->input("category_id"));
        $folder   = $category ? ($category->slug ?: Str::slug($category->name)) : "lainnya";
        $dir      = public_path("images/books/" . $folder);

        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: "cover";
        $ext  = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension());
        $filename = $name . "." . $ext;

        // jangan menimpa file yang sudah ada
        if (file_exists($dir . "/" . $filename)) {
            $filename = $name . "-" . time() . "." . $ext;
        }

        $file->move($dir, $filename);

        $validated["cover"] = $filename;

        return $validated;
    }

    private function validateBook(Request $request, $ignoreId = null): array
    {
        // "cover" bisa berupa teks (nama file) atau file gambar, tergantung isi form
        $coverRule = $request->hasFile("cover")
            ? ["nullable", "image", "mimes:jpg,jpeg,png,webp", "max:2048"]
            : ["nullable", "string", "max:255"];

        $validated = $request->validate([
            "book_code" => ["required", "string", "max:50", "unique:books,book_code," . $ignoreId],
            "title" => ["required", "string", "max:255"],
            "author" => ["nullable", "string", "max:255"],
            "publisher" => ["nullable", "string", "max:255"],
            "year" => ["nullable", "digits:4", "integer", "min:1900", "max:" . (date("Y") + 1)],
            "category_id" => ["required", "exists:categories,id"],
            "stock" => ["required", "integer", "min:0"],
            "rack_number" => ["nullable", "integer", "between:1," . config("perpustakaan.jumlah_rak", 7), "required_with:shelf_row"],
            "shelf_row" => ["nullable", "integer", "between:1," . config("perpustakaan.baris_per_rak", 4), "required_with:rack_number"],
            "cover" => $coverRule,
            "cover_file" => ["nullable", "image", "mimes:jpg,jpeg,png,webp", "max:2048"],
            "description" => ["nullable", "string"],
        ], [
            "cover_file.image" => "File cover harus berupa gambar.",
            "cover_file.mimes" => "Format cover harus JPG, PNG, atau WEBP.",
            "cover_file.max"   => "Ukuran cover maksimal 2 MB.",
        ]);

        // Field kosong dari form dikirim sebagai "" -> ubah jadi NULL supaya
        // kolom angka (year, rack_number, shelf_row) tidak error di MySQL.
        foreach ($validated as $key => $value) {
            if ($value === "") {
                $validated[$key] = null;
            }
        }

        return $validated;
    }
}