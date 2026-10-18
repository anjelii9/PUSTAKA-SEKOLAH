<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Dashboard profil: bio data + riwayat peminjaman (data yang sama persis
    // dengan yang dilihat admin, karena diambil dari tabel transactions yang sama)
    // + notifikasi kalau ada denda yang belum lunas.
    public function edit(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        $transactions = $member
            ? $member->transactions()->with("book")->latest()->get()
            : collect();

        $totalDenda = $transactions->sum("fine");
        $transaksiDenda = $transactions->where("fine", ">", 0);

        return view("student.profile.edit", compact("user", "member", "transactions", "totalDenda", "transaksiDenda"));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "email", "unique:users,email," . $user->id],
            "phone" => ["nullable", "string", "max:20"],
            "class" => ["nullable", "string", "max:50"],
            "address" => ["nullable", "string", "max:255"],
            "password" => ["nullable", "confirmed", Password::min(8)],
        ]);

        $user->update([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "phone" => $validated["phone"] ?? null,
            "password" => ! empty($validated["password"]) ? Hash::make($validated["password"]) : $user->password,
        ]);

        if ($user->member) {
            $user->member->update([
                "name" => $validated["name"],
                "class" => $validated["class"] ?? $user->member->class,
                "phone" => $validated["phone"] ?? $user->member->phone,
                "address" => $validated["address"] ?? $user->member->address,
            ]);
        }

        return back()->with("success", "Profil berhasil diperbarui.");
    }
}
