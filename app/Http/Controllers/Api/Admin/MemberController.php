<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::when($request->q, function ($q) use ($request) {
                $q->where("name", "like", "%{$request->q}%")->orWhere("member_code", "like", "%{$request->q}%");
            })
            ->latest()
            ->paginate($request->integer("per_page", 15));

        return JsonResource::collection($members);
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
            "password" => ["nullable", "string", "min:8"],
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

        $member = Member::create([
            "user_id" => $userId,
            "member_code" => "SIS-" . strtoupper(Str::random(6)),
            "name" => $validated["name"],
            "class" => $validated["class"],
            "phone" => $validated["phone"] ?? null,
            "address" => $validated["address"] ?? null,
            "status" => $validated["status"],
        ]);

        return response()->json($member);
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
        return response()->json($member->fresh());
    }

    public function destroy(Member $member)
    {
        if ($member->activeTransactions()->exists()) {
            return response()->json(["message" => "Anggota masih memiliki peminjaman aktif."], 422);
        }

        $member->delete();
        return response()->json(["message" => "Anggota dihapus."]);
    }
}
