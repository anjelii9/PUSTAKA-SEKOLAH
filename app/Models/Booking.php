<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        "booking_code", "book_id", "member_id", "transaction_id",
        "booking_date", "pickup_time", "status", "confirmed_at", "cancelled_at", "is_read",
    ];

    protected $casts = [
        "booking_date" => "date",
        "confirmed_at" => "datetime",
        "cancelled_at" => "datetime",
        "is_read" => "boolean",
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Gabungan tanggal + jam pengambilan jadi satu waktu utuh
    public function pickupDateTime(): Carbon
    {
        return Carbon::parse($this->booking_date->format("Y-m-d") . " " . $this->pickup_time);
    }

    public function deadline(): Carbon
    {
        return $this->pickupDateTime()->addMinutes(10);
    }

    public function isExpired(): bool
    {
        return $this->status === "menunggu" && now()->gt($this->deadline());
    }

    public static function autoCancelExpired(): void
    {
        $menunggu = self::with("book")->where("status", "menunggu")->get();

        foreach ($menunggu as $booking) {
            if ($booking->isExpired()) {
                $booking->update([
                    "status" => "dibatalkan",
                    "cancelled_at" => now(),
                    "is_read" => false,
                ]);
                $booking->book()->increment("stock");
            }
        }
    }
}