<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Student',
                'slug' => 'student',
                'description' => 'Student of a university',
            ],
            [
                'name' => 'Lecturer',
                'slug' => 'lecturer',
                'description' => 'University lecturer',
            ],
            [
                'name' => 'University Admin',
                'slug' => 'university_admin',
                'description' => 'Administrator of a university',
            ],
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'description' => 'Platform administrator',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}