<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalBuku = Book::count();
        $totalStok = Book::sum("stock");
        $transaksiAktif = Transaction::whereIn("status", ["dipinjam", "terlambat"])->count();
        $terlambat = Transaction::where("status", "dipinjam")->where("due_date", "<", Carbon::today())->count();
        $totalAnggota = Member::count();

        // Daftar lengkap transaksi (dengan pencarian dan filter status)
        $transactions = Transaction::with(["book", "member"])
            ->when($request->status, fn ($q) => $q->where("status", $request->status))
            ->when($request->q, function ($q) use ($request) {
                $q->where(function ($w) use ($request) {
                    $w->whereHas("book", fn ($b) => $b->where("title", "like", "%{$request->q}%"))
                      ->orWhereHas("member", fn ($m) => $m->where("name", "like", "%{$request->q}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view("admin.dashboard.index", compact(
            "totalBuku", "totalStok", "transaksiAktif", "terlambat", "totalAnggota", "transactions"
        ));
    }
}