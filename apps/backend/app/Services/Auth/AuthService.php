<?php

namespace App\Services\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function me(User $user): User
    {
        return $user->load('role');
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

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

            return $this->createAuthResponse($user);
        });
    }

    private function createAuthResponse(User $user): array
    {
        return [
            'user' => $user->load('role'),
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];
    }

    public function login(array $credentials): array
    {
        $user = User::with('role')
            ->where('email', $credentials['email'])
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your account has been deactivated.'],
            ]);
        }

        $user->update([
            'last_login_at' => now(),
        ]);

        return $this->createAuthResponse($user);
    }
}
