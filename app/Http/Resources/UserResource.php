<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "role" => $this->role,
            "member" => $this->whenLoaded("member", fn () => [
                "member_code" => $this->member->member_code,
                "class" => $this->member->class,
                "address" => $this->member->address,
                "status" => $this->member->status,
            ]),
        ];
    }
}
