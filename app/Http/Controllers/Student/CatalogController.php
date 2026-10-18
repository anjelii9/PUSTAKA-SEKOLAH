<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with("category")
            ->when($request->q, fn ($q) => $q->search($request->q))
            ->when($request->category_id, fn ($q) => $q->where("category_id", $request->category_id))
            ->orderBy("title")
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy("name")->get();

        return view("student.catalog.index", compact("books", "categories"));
    }

    public function show(Book $book)
    {
        return view("student.catalog.show", compact("book"));
    }
}
