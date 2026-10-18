<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "quote" => $this->quote,
            "role_label" => $this->role_label,
            "user_name" => $this->user->name ?? "Anggota",
            "created_at" => $this->created_at?->format("Y-m-d"),
        ];
    }
}
