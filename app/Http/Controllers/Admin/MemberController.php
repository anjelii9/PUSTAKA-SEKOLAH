<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::when($request->q, function ($q) use ($request) {
                $q->where("name", "like", "%{$request->q}%")
                  ->orWhere("member_code", "like", "%{$request->q}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view("admin.members.index", compact("members"));
    }

    public function create()
    {
        return view("admin.members.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "string", "max:255"],
            "class" => ["required", "string", "max:50"],
            "phone" => ["nullable", "string", "max:20"],
            "address" => ["nullable", "string", "max:255"],
            "status" => ["required", "in:aktif,nonaktif"],
            "email" => ["nullable", "email", "unique:users,email"],
            "password" => ["nullable", Password::min(8)],
        ]);

        $userId = null;
        if (! empty($validated["email"])) {
            $user = User::create([
                "name" => $validated["name"],
                "email" => $validated["email"],
                "password" => Hash::make($validated["password"] ?? Str::random(10)),
                "role" => "siswa",
                "phone" => $validated["phone"] ?? null,
            ]);
            $userId = $user->id;
        }

        Member::create([
            "user_id" => $userId,
            "member_code" => "SIS-" . strtoupper(Str::random(6)),
            "name" => $validated["name"],
            "class" => $validated["class"],
            "phone" => $validated["phone"] ?? null,
            "address" => $validated["address"] ?? null,
            "status" => $validated["status"],
        ]);

        return redirect()->route("admin.members.index")->with("success", "Anggota berhasil ditambahkan.");
    }

    // Halaman cetak kartu anggota
    public function card(Member $member)
    {
        return view("admin.members.card", compact("member"));
    }

    public function edit(Member $member)
    {
        return view("admin.members.edit", compact("member"));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            "name" => ["required", "string", "max:255"],
            "class" => ["required", "string", "max:50"],
            "phone" => ["nullable", "string", "max:20"],
            "address" => ["nullable", "string", "max:255"],
            "status" => ["required", "in:aktif,nonaktif"],
        ]);

        $member->update($validated);

        return redirect()->route("admin.members.index")->with("success", "Data anggota berhasil diperbarui.");
    }

    public function destroy(Member $member)
    {
        if ($member->activeTransactions()->exists()) {
            return back()->with("error", "Anggota tidak dapat dihapus karena masih memiliki peminjaman aktif.");
        }

        $member->delete();

        return redirect()->route("admin.members.index")->with("success", "Anggota berhasil dihapus.");
    }
}