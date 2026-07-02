<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
            'email' => $this->email,

            'role' => [
                'name' => $this->role->name,
                'slug' => $this->role->slug,
            ],

            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
        ];
    }
}