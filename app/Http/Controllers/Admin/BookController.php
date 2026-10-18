<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
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

        if ($request->hasFile("cover")) {
            $validated["cover"] = $request->file("cover")->store("covers", "public");
        }

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

        if ($request->hasFile("cover")) {
            $validated["cover"] = $request->file("cover")->store("covers", "public");
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

    private function validateBook(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            "book_code" => ["required", "string", "max:50", "unique:books,book_code," . $ignoreId],
            "title" => ["required", "string", "max:255"],
            "author" => ["nullable", "string", "max:255"],
            "publisher" => ["nullable", "string", "max:255"],
            "year" => ["nullable", "digits:4", "integer", "min:1900", "max:" . (date("Y") + 1)],
            "category_id" => ["required", "exists:categories,id"],
            "stock" => ["required", "integer", "min:0"],
            "cover" => ["nullable", "image", "max:2048"],
            "description" => ["nullable", "string"],
        ]);
    }
}
