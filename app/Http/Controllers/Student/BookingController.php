<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // Jam operasional pengambilan buku: 08.00 - 15.00 WIB, interval 30 menit
    private function timeSlots(): array
    {
        $slots = [];
        $start = Carbon::createFromTime(8, 0);
        $end = Carbon::createFromTime(15, 0);

        while ($start->lte($end)) {
            $slots[] = $start->format("H:i");
            $start->addMinutes(30);
        }

        return $slots;
    }

    public function create(Request $request, Book $book)
    {
        Booking::autoCancelExpired();
        $book->refresh();

        if (! $book->isAvailable()) {
            return back()->with("error", "Buku \"{$book->title}\" sedang tidak tersedia untuk di-booking.");
        }

        $member = $request->user()->member;
        if (! $member) {
            return back()->with("error", "Akun kamu belum terdaftar sebagai anggota perpustakaan.");
        }

        $sudahBooking = Booking::where("book_id", $book->id)
            ->where("member_id", $member->id)
            ->where("status", "menunggu")
            ->exists();

        if ($sudahBooking) {
            return back()->with("error", "Kamu sudah punya booking aktif untuk buku ini. Tunggu sampai diambil/dibatalkan dulu.");
        }

        $slots = $this->timeSlots();

        return view("student.booking.create", compact("book", "slots"));
    }

    public function store(Request $request, Book $book)
    {
        Booking::autoCancelExpired();
        $book->refresh();

        $validated = $request->validate([
            "pickup_time" => ["required", "date_format:H:i", "after_or_equal:08:00", "before_or_equal:15:00"],
            "agree" => ["required", "accepted"],
        ], [
            "agree.required" => "Kamu harus menyetujui peraturan booking terlebih dahulu.",
            "agree.accepted" => "Kamu harus menyetujui peraturan booking terlebih dahulu.",
            "pickup_time.required" => "Pilih jam pengambilan terlebih dahulu.",
        ]);

        if (! $book->isAvailable()) {
            return back()->with("error", "Buku ini sudah tidak tersedia untuk di-booking.")->withInput();
        }

        $member = $request->user()->member;
        if (! $member) {
            return back()->with("error", "Akun kamu belum terdaftar sebagai anggota perpustakaan.");
        }

        // Jam yang dipilih tidak boleh sudah lewat dari sekarang (hari ini)
        $pickupDateTime = Carbon::today()->setTimeFromTimeString($validated["pickup_time"]);
        if ($pickupDateTime->isPast()) {
            return back()->with("error", "Jam pengambilan yang dipilih sudah lewat. Silakan pilih jam lain.")->withInput();
        }

        Booking::create([
            "booking_code" => "BOOK-" . now()->format("Ymd") . "-" . strtoupper(Str::random(4)),
            "book_id" => $book->id,
            "member_id" => $member->id,
            "booking_date" => Carbon::today(),
            "pickup_time" => $validated["pickup_time"],
            "status" => "menunggu",
        ]);

        $book->decrement("stock");

        // NOTIFIKASI LOKASI BUKU: contoh "Buku berada di rak nomor 1 baris 2."
        $lokasi = $book->locationMessage();

        return redirect()->route("student.profile")->with(
            "success",
            "Booking berhasil! {$lokasi}. Ambil buku jam {$validated["pickup_time"]} WIB, maksimal telat 10 menit ya."
        );
    }
}