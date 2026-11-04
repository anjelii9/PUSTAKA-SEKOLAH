<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "book_code", "title", "author", "publisher", "year",
        "category_id", "stock", "rack_number", "shelf_row", "cover", "description",
    ];

    protected $appends = ["cover_url"];

    // Cover dibaca dari public/images/books/<slug-kategori>/<nama-file>
    // Isi kolom "cover" bisa: "5cm.jpg", "5cm" (tanpa ekstensi), atau "novel/5cm.jpg"
    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover) {
            return null;
        }

        $base  = public_path("images/books");
        $cover = ltrim(str_replace("\\", "/", trim($this->cover)), "/");

        
        $folders = [""];
        if (! str_contains($cover, "/")) {
            $folders = [];
            if ($this->category) {
                $folders[] = $this->category->slug . "/";
            }
            if (is_dir($base)) {
                foreach (File::directories($base) as $dir) {
                    $folders[] = basename($dir) . "/";
                }
            }
            $folders = array_unique($folders);
        }

        foreach ($folders as $folder) {
            foreach (["", ".jpg", ".jpeg", ".png", ".webp"] as $ext) {
                if (is_file($base . "/" . $folder . $cover . $ext)) {
                    return asset("images/books/" . $folder . $cover . $ext);
                }
            }
        }

        return null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }

   
    public function locationMessage(): string
    {
        if (! $this->rack_number || ! $this->shelf_row) {
            return "Lokasi buku belum diatur, tanyakan ke petugas perpustakaan";
        }

        return "Buku berada di rak nomor {$this->rack_number} baris {$this->shelf_row}";
    }

  
    public function locationShort(): string
    {
        if (! $this->rack_number || ! $this->shelf_row) {
            return "-";
        }

        return "Rak {$this->rack_number} / Baris {$this->shelf_row}";
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