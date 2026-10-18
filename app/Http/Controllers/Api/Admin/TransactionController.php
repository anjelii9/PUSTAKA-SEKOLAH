<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Book;
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
            ->latest()
            ->paginate($request->integer("per_page", 15));

        return TransactionResource::collection($transactions);
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
            return response()->json(["message" => "Stok buku sedang habis."], 422);
        }

        $lamaPinjam = (int) config("perpustakaan.lama_pinjam_hari", 7);
        $borrowDate = Carbon::today();
        $dueDate = $borrowDate->copy()->addDays($lamaPinjam);

        $transaction = Transaction::create([
            "transaction_code" => "TRX-" . now()->format("Ymd") . "-" . strtoupper(Str::random(4)),
            "book_id" => $book->id,
            "member_id" => $validated["member_id"],
            "admin_id" => $request->user()->id,
            "borrow_date" => $borrowDate,
            "due_date" => $dueDate,
            "status" => "dipinjam",
            "notes" => $validated["notes"] ?? null,
        ]);

        $book->decrement("stock");

        return new TransactionResource($transaction->load(["book", "member"]));
    }

    public function processReturn(Transaction $transaction)
    {
        if ($transaction->status === "dikembalikan") {
            return response()->json(["message" => "Transaksi ini sudah dikembalikan."], 422);
        }

        $returnDate = Carbon::today();
        $fine = 0;

        if ($returnDate->gt($transaction->due_date)) {
            $daysLate = $transaction->due_date->diffInDays($returnDate);
            $perDay = (int) config("perpustakaan.denda_per_hari", 1000);
            $fine = $daysLate * $perDay;
        }

        $transaction->update(["return_date" => $returnDate, "status" => "dikembalikan", "fine" => $fine]);
        $transaction->book()->increment("stock");

        return new TransactionResource($transaction->fresh()->load(["book", "member"]));
    }
}
