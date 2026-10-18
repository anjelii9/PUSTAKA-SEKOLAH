<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with("user")->where("is_published", true)->latest()->take(10)->get();
        return TestimonialResource::collection($testimonials);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "quote" => ["required", "string", "min:10", "max:500"],
            "role_label" => ["nullable", "string", "max:100"],
        ]);

        $user = $request->user();
        $defaultLabel = $user->member?->class ? "Siswa Kelas {$user->member->class}" : "Anggota Perpustakaan";

        $testimonial = Testimonial::updateOrCreate(
            ["user_id" => $user->id],
            ["quote" => $validated["quote"], "role_label" => $validated["role_label"] ?: $defaultLabel, "is_published" => true]
        );

        return new TestimonialResource($testimonial->load("user"));
    }

    public function destroy(Request $request)
    {
        Testimonial::where("user_id", $request->user()->id)->delete();
        return response()->json(["message" => "Testimoni dihapus."]);
    }
}
