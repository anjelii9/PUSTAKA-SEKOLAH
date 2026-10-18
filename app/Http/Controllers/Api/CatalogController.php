<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Resources\CategoryResource;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function categories()
    {
        return CategoryResource::collection(
            Category::withCount("books")->orderBy("name")->get()
        );
    }

    public function books(Request $request)
    {
        $books = Book::with("category")
            ->when($request->q, fn ($q) => $q->search($request->q))
            ->when($request->category_id, fn ($q) => $q->where("category_id", $request->category_id))
            ->orderBy("title")
            ->paginate($request->integer("per_page", 12));

        return BookResource::collection($books);
    }

    public function show(Book $book)
    {
        return new BookResource($book->load("category"));
    }
}
