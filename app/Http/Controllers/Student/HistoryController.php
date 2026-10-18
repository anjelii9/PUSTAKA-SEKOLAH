<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $member = $request->user()->member;

        $transactions = $member
            ? $member->transactions()->with("book")->latest()->paginate(10)
            : collect();

        return view("student.history.index", compact("transactions", "member"));
    }
}
