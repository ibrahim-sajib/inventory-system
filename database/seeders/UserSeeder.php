<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'full_name' => 'Jack Admin',
            'user_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'status' => 'active',
        ]);

        // $seller = User::create([
        //     'full_name' => 'Jack Seller',
        //     'user_name' => 'Seller',
        //     'email' => 'seller@tbuy.com',
        //     'password' => Hash::make('p@ssword10'),
        //     'status' => 'active',
        // ]);

        // $buyer = User::create([
        //     'full_name' => 'Jack Buyer',
        //     'user_name' => 'Buyer',
        //     'email' => 'buyer@tbuy.com',
        //     'password' => Hash::make('p@ssword10'),
        //     'status' => 'active',
        // ]);

        // Assign roles
        $admin->assignRole('admin');
        // $seller->assignRole('seller');
        // $buyer->assignRole('buyer');

    }
}
