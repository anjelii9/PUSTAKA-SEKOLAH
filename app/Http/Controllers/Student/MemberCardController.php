<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MemberCardController extends Controller
{
    // Halaman "Kartu Anggota" siswa: lengkapi data + upload foto
    public function show(Request $request)
    {
        $member = $request->user()->member;

        return view("student.card.index", [
            "member" => $member,
            "missing" => $member ? $member->missingProfileFields() : [],
        ]);
    }

    // Simpan data yang dibutuhkan kartu
    public function update(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        abort_unless($member, 404);

        $validated = $request->validate([
            "class" => ["required", "string", "max:50"],
            "phone" => ["required", "string", "max:20"],
            "address" => ["required", "string", "max:255"],
            "photo" => [$member->photo_url ? "nullable" : "required", "image", "mimes:jpg,jpeg,png,webp", "max:2048"],
        ], [
            "class.required" => "Kelas wajib diisi.",
            "phone.required" => "No. HP wajib diisi.",
            "address.required" => "Alamat wajib diisi.",
            "photo.required" => "Foto formal wajib diunggah.",
            "photo.image" => "Foto harus berupa gambar.",
            "photo.mimes" => "Format foto harus JPG, PNG, atau WEBP.",
            "photo.max" => "Ukuran foto maksimal 2 MB.",
        ]);

        $member->update(Arr::only($validated, ["class", "phone", "address"]));
        $user->update(["phone" => $validated["phone"]]);

        if ($request->hasFile("photo")) {
            $member->savePhoto($request->file("photo"));
        }

        return redirect()->route("student.card")->with("success", "Data kartu berhasil disimpan.");
    }

    // Halaman cetak: hanya bisa kalau semua data sudah lengkap
    public function print(Request $request)
    {
        $member = $request->user()->member;

        if (! $member) {
            return redirect()->route("student.card")->with("error", "Akunmu belum terdaftar sebagai anggota perpustakaan.");
        }

        if (! $member->isProfileComplete()) {
            return redirect()->route("student.card")->with("error", "Lengkapi data dan foto formal dulu sebelum mencetak kartu.");
        }

        // Memakai tampilan kartu yang sama dengan admin
        return view("admin.members.card", [
            "member" => $member,
            "backUrl" => route("student.card"),
        ]);
    }
}