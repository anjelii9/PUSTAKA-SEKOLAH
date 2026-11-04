<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id", "member_code", "name", "class", "phone", "address", "status", "photo",
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

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // URL foto formal (null kalau belum ada / file hilang). Disimpan di public/uploads/members/
    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo) {
            return null;
        }

        if (! is_file(public_path("uploads/members/" . $this->photo))) {
            return null;
        }

        return asset("uploads/members/" . $this->photo);
    }

    // Simpan foto baru dan hapus foto lama
    public function savePhoto(UploadedFile $file): void
    {
        $dir = public_path("uploads/members");

        $ext  = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension());
        $name = Str::slug($this->member_code ?: "anggota") . "-" . time() . "." . $ext;

        $file->move($dir, $name);

        if ($this->photo && is_file($dir . "/" . $this->photo)) {
            @unlink($dir . "/" . $this->photo);
        }

        $this->photo = $name;
        $this->save();
    }

    // Data yang wajib diisi sebelum siswa boleh mencetak kartu: [field => label]
    public function missingProfileFields(): array
    {
        $missing = [];

        if (blank($this->class))   { $missing["class"]   = "Kelas"; }
        if (blank($this->phone))   { $missing["phone"]   = "No. HP"; }
        if (blank($this->address)) { $missing["address"] = "Alamat"; }
        if (! $this->photo_url)    { $missing["photo"]   = "Foto formal"; }

        return $missing;
    }

    public function isProfileComplete(): bool
    {
        return empty($this->missingProfileFields());
    }
}