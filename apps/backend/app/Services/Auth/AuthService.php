<?php

namespace App\Services\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthService
{
    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {

            $role = Role::where('slug', $data['role'])->firstOrFail();

            $user = User::create([
                'role_id' => $role->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return compact('user', 'token');
        });
    }
}