<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view("auth.register");
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:255", "unique:users,email"],
            "password" => ["required", "confirmed", Password::min(8)],
            "class" => ["required", "string", "max:50"],
            "phone" => ["nullable", "string", "max:20"],
            "address" => ["nullable", "string", "max:255"],
        ]);

        $user = User::create([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "password" => Hash::make($validated["password"]),
            "role" => "siswa",
            "phone" => $validated["phone"] ?? null,
        ]);

        Member::create([
            "user_id" => $user->id,
            "member_code" => "SIS-" . strtoupper(Str::random(6)),
            "name" => $validated["name"],
            "class" => $validated["class"],
            "phone" => $validated["phone"] ?? null,
            "address" => $validated["address"] ?? null,
            "status" => "aktif",
        ]);

        Auth::login($user);

        return redirect()->route("student.catalog")->with("success", "Registrasi berhasil! Selamat datang di Perpustakaan Sekolah.");
    }
}
