<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
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

        $token = $user->createToken("flutter-app")->plainTextToken;

        return response()->json([
            "user" => new UserResource($user->load("member")),
            "token" => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json(["message" => "Email atau password salah."], 401);
        }

        $user = User::where("email", $credentials["email"])->firstOrFail();
        $token = $user->createToken("flutter-app")->plainTextToken;

        return response()->json([
            "user" => new UserResource($user->load("member")),
            "token" => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(["message" => "Berhasil keluar."]);
    }

    public function me(Request $request)
    {
        return new UserResource($request->user()->load("member"));
    }
}
