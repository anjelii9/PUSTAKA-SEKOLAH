<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount("books")->take(6)->get();

        $latestBooks = Book::with("category")
            ->when($request->q, fn ($q) => $q->search($request->q))
            ->latest()
            ->take(8)
            ->get();

        $testimonials = Testimonial::with("user")
            ->where("is_published", true)
            ->latest()
            ->take(6)
            ->get();

        $myTestimonial = $request->user() && $request->user()->isSiswa()
            ? Testimonial::where("user_id", $request->user()->id)->first()
            : null;

        return view("home.index", compact("categories", "latestBooks", "testimonials", "myTestimonial"));
    }
}
