<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            "total_buku" => Book::count(),
            "total_stok" => Book::sum("stock"),
            "transaksi_aktif" => Transaction::whereIn("status", ["dipinjam", "terlambat"])->count(),
            "terlambat" => Transaction::where("status", "dipinjam")->where("due_date", "<", Carbon::today())->count(),
            "total_anggota" => Member::count(),
        ]);
    }
}
