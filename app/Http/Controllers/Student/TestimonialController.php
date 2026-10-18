<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            "quote" => ["required", "string", "min:10", "max:500"],
            "role_label" => ["nullable", "string", "max:100"],
        ]);

        $user = $request->user();
        $defaultLabel = $user->member?->class
            ? "Siswa Kelas {$user->member->class}"
            : "Anggota Perpustakaan";

        Testimonial::updateOrCreate(
            ["user_id" => $user->id],
            [
                "quote" => $validated["quote"],
                "role_label" => $validated["role_label"] ?: $defaultLabel,
                "is_published" => true,
            ]
        );

        return back()->with("success", "Terima kasih! Testimonimu berhasil dikirim dan tampil di beranda.");
    }

    public function destroy(Request $request)
    {
        Testimonial::where("user_id", $request->user()->id)->delete();

        return back()->with("success", "Testimonimu berhasil dihapus.");
    }
}
