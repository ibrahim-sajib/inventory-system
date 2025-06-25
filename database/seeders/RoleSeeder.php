<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'buyer',
            'seller',
        ];

        Role::insert(array_map(fn ($role) => [
            'name' => $role,
            'guard_name' => config('auth.defaults.guard'),
        ], $roles));

    }
}
