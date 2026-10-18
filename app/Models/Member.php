<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id", "member_code", "name", "class", "phone", "address", "status",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function activeTransactions()
    {
        return $this->transactions()->whereIn("status", ["dipinjam", "terlambat"]);
    }
}
