<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProductSeeder::class);
        

        // User::factory(20)->create()->each(function ($user) {
        //     $roles = RoleType::all();
        //     $randomRole = array_rand($roles);

        //     $user->assignRole($roles[$randomRole]);
        // });
    }
}
