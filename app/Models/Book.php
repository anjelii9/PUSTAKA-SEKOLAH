<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "book_code", "title", "author", "publisher", "year",
        "category_id", "stock", "cover", "description",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where("title", "like", "%{$term}%")
              ->orWhere("author", "like", "%{$term}%")
              ->orWhere("book_code", "like", "%{$term}%")
              ->orWhereHas("category", fn ($c) => $c->where("name", "like", "%{$term}%"));
        });
    }
}
