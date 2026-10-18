<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with("category")
            ->when($request->q, fn ($q) => $q->search($request->q))
            ->when($request->category_id, fn ($q) => $q->where("category_id", $request->category_id))
            ->latest()
            ->paginate($request->integer("per_page", 15));

        return BookResource::collection($books);
    }

    public function store(Request $request)
    {
        $validated = $this->validateBook($request);

        if ($request->hasFile("cover")) {
            $validated["cover"] = $request->file("cover")->store("covers", "public");
        }

        $book = Book::create($validated);
        return new BookResource($book->load("category"));
    }

    public function show(Book $book)
    {
        return new BookResource($book->load("category"));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $this->validateBook($request, $book->id);

        if ($request->hasFile("cover")) {
            $validated["cover"] = $request->file("cover")->store("covers", "public");
        }

        $book->update($validated);
        return new BookResource($book->fresh()->load("category"));
    }

    public function destroy(Book $book)
    {
        if ($book->transactions()->whereIn("status", ["dipinjam", "terlambat"])->exists()) {
            return response()->json(["message" => "Buku tidak dapat dihapus karena masih ada peminjaman aktif."], 422);
        }

        $book->delete();
        return response()->json(["message" => "Buku dihapus."]);
    }

    private function validateBook(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            "book_code" => ["required", "string", "max:50", "unique:books,book_code," . $ignoreId],
            "title" => ["required", "string", "max:255"],
            "author" => ["nullable", "string", "max:255"],
            "publisher" => ["nullable", "string", "max:255"],
            "year" => ["nullable", "digits:4", "integer"],
            "category_id" => ["required", "exists:categories,id"],
            "stock" => ["required", "integer", "min:0"],
            "cover" => ["nullable", "image", "max:2048"],
            "description" => ["nullable", "string"],
        ]);
    }
}
