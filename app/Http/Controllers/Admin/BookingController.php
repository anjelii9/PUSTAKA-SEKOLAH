<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Bersihkan dulu booking yang udah lewat batas toleransi sebelum ditampilkan
        Booking::autoCancelExpired();

        $bookings = Booking::with(["book", "member"])
            ->when($request->status, fn ($q) => $q->where("status", $request->status))
            ->orderByRaw("CASE WHEN status = 'menunggu' THEN 0 ELSE 1 END")
            ->latest("booking_date")
            ->latest("pickup_time")
            ->paginate(15)
            ->withQueryString();

        return view("admin.bookings.index", compact("bookings"));
    }

    public function confirm(Request $request, Booking $booking)
    {
        Booking::autoCancelExpired();
        $booking->refresh();

        if ($booking->status !== "menunggu") {
            return back()->with("error", "Booking ini sudah tidak berstatus menunggu (kemungkinan sudah dikonfirmasi/dibatalkan).");
        }

        $lamaPinjam = (int) config("perpustakaan.lama_pinjam_hari", 7);
        $borrowDate = Carbon::today();
        $dueDate = $borrowDate->copy()->addDays($lamaPinjam);

        // Stok TIDAK dikurangi lagi di sini -- sudah direservasi (dikurangi) sejak booking dibuat.
        $transaction = $booking->book->transactions()->create([
            "transaction_code" => "TRX-" . now()->format("Ymd") . "-" . strtoupper(Str::random(4)),
            "member_id" => $booking->member_id,
            "admin_id" => $request->user()->id,
            "borrow_date" => $borrowDate,
            "due_date" => $dueDate,
            "status" => "dipinjam",
            "notes" => "Dari booking {$booking->booking_code}",
        ]);

        $booking->update([
            "status" => "dikonfirmasi",
            "confirmed_at" => now(),
            "transaction_id" => $transaction->id,
            "is_read" => false,
        ]);

        return redirect()->route("admin.bookings.index")->with("success", "Booking {$booking->booking_code} dikonfirmasi, buku resmi dipinjamkan. Jatuh tempo: {$dueDate->format("d-m-Y")}.");
    }
}
