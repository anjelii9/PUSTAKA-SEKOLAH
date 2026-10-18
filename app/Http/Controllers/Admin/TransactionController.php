<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with(["book", "member"])
            ->when($request->status, fn ($q) => $q->where("status", $request->status))
            ->when($request->q, function ($q) use ($request) {
                $q->whereHas("book", fn ($b) => $b->where("title", "like", "%{$request->q}%"))
                  ->orWhereHas("member", fn ($m) => $m->where("name", "like", "%{$request->q}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view("admin.transactions.index", compact("transactions"));
    }

    public function create()
    {
        $books = Book::where("stock", ">", 0)->orderBy("title")->get();
        $members = Member::where("status", "aktif")->orderBy("name")->get();

        return view("admin.transactions.create", compact("books", "members"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "book_id" => ["required", "exists:books,id"],
            "member_id" => ["required", "exists:members,id"],
            "notes" => ["nullable", "string", "max:255"],
        ]);

        $book = Book::findOrFail($validated["book_id"]);

        if (! $book->isAvailable()) {
            // INI BAGIAN YANG TADI SALAH KETIK, SEKARANG SUDAH BENAR
            return back()->with("error", "Stok buku '{$book->title}' sedang habis / tidak tersedia.")->withInput();
        }

        $lamaPinjam = (int) config("perpustakaan.lama_pinjam_hari", 7);
        $borrowDate = Carbon::today();
        $dueDate = $borrowDate->copy()->addDays($lamaPinjam);

        Transaction::create([
            "transaction_code" => "TRX-" . now()->format("Ymd") . "-" . strtoupper(Str::random(4)),
            "book_id" => $book->id,
            "member_id" => $validated["member_id"],
            "admin_id" => auth()->id(),
            "borrow_date" => $borrowDate,
            "due_date" => $dueDate,
            "status" => "dipinjam",
            "notes" => $validated["notes"] ?? null,
        ]);

        $book->decrement("stock");

        return redirect()->route("admin.transactions.index")->with("success", "Peminjaman berhasil dicatat. Jatuh tempo: {$dueDate->format('d-m-Y')}.");
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(["book", "member", "admin"]);
        return view("admin.transactions.show", compact("transaction"));
    }

    public function returnForm(Transaction $transaction)
    {
        $estimasiDenda = $transaction->calculateFine();
        return view("admin.transactions.return", compact("transaction", "estimasiDenda"));
    }

    public function processReturn(Request $request, Transaction $transaction)
    {
        if ($transaction->status === "dikembalikan") {
            return back()->with("error", "Transaksi ini sudah dikembalikan sebelumnya.");
        }

        $returnDate = Carbon::today();
        $fine = 0;

        if ($returnDate->gt($transaction->due_date)) {
            $daysLate = $transaction->due_date->diffInDays($returnDate);
            $perDay = (int) config("perpustakaan.denda_per_hari", 1000);
            $fine = $daysLate * $perDay;
        }

        $transaction->update([
            "return_date" => $returnDate,
            "status" => "dikembalikan",
            "fine" => $fine,
        ]);

        $transaction->book()->increment("stock");

        $pesan = $fine > 0
            ? "Buku dikembalikan dengan keterlambatan. Denda: Rp " . number_format($fine, 0, ",", ".")
            : "Buku berhasil dikembalikan tepat waktu.";

        return redirect()->route("admin.transactions.index")->with("success", $pesan);
    }

    public function updateStatus(Transaction $transaction)
    {
        if ($transaction->status === "dipinjam" && Carbon::today()->gt($transaction->due_date)) {
            $transaction->update(["status" => "terlambat"]);
        }

        return back()->with("success", "Status transaksi diperbarui.");
    }
}