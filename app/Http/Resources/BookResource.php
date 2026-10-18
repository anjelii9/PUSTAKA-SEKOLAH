<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "book_code" => $this->book_code,
            "title" => $this->title,
            "author" => $this->author,
            "publisher" => $this->publisher,
            "year" => $this->year,
            "stock" => $this->stock,
            "is_available" => $this->isAvailable(),
            "cover_url" => $this->cover ? asset("storage/" . $this->cover) : null,
            "description" => $this->description,
            "category" => [
                "id" => $this->category->id ?? null,
                "name" => $this->category->name ?? null,
            ],
        ];
    }
}
