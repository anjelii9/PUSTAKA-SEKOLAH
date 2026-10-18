<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Book::count();
        $totalStok = Book::sum("stock");
        $transaksiAktif = Transaction::whereIn("status", ["dipinjam", "terlambat"])->count();
        $terlambat = Transaction::where("status", "dipinjam")->where("due_date", "<", Carbon::today())->count();
        $totalAnggota = Member::count();
        $transaksiTerbaru = Transaction::with(["book", "member"])->latest()->take(8)->get();

        return view("admin.dashboard.index", compact(
            "totalBuku", "totalStok", "transaksiAktif", "terlambat", "totalAnggota", "transaksiTerbaru"
        ));
    }
}
