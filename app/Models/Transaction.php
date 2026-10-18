<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        "transaction_code", "book_id", "member_id", "admin_id",
        "borrow_date", "due_date", "return_date", "status", "fine", "notes",
    ];

    protected $casts = [
        "borrow_date" => "date",
        "due_date" => "date",
        "return_date" => "date",
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, "admin_id");
    }

    public function isLate(): bool
    {
        $end = $this->return_date ?? Carbon::today();
        return $end->gt($this->due_date);
    }

    public function calculateFine(): int
    {
        $end = $this->return_date ?? Carbon::today();
        if ($end->lte($this->due_date)) {
            return 0;
        }
        $daysLate = $this->due_date->diffInDays($end);
        $perDay = (int) config("perpustakaan.denda_per_hari", 1000);
        return $daysLate * $perDay;
    }
}
