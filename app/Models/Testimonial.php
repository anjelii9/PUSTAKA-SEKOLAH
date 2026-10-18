<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "role_label", "quote", "is_published"];
    protected $casts = ["is_published" => "boolean"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
