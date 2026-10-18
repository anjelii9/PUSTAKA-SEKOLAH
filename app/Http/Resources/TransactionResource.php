<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "transaction_code" => $this->transaction_code,
            "book" => [
                "id" => $this->book->id ?? null,
                "title" => $this->book->title ?? null,
                "cover_url" => $this->book && $this->book->cover ? asset("storage/" . $this->book->cover) : null,
            ],
            "borrow_date" => $this->borrow_date?->format("Y-m-d"),
            "due_date" => $this->due_date?->format("Y-m-d"),
            "return_date" => $this->return_date?->format("Y-m-d"),
            "status" => $this->status,
            "fine" => $this->fine,
            "is_late" => $this->isLate(),
        ];
    }
}
