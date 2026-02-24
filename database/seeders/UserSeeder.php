<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a vendor user
        User::firstOrCreate(
            ['email' => 'vendor@gmail.com'],
            [
                'name' => 'Vendor User',
                'username' => 'vendor',
                'role' => 'vendor',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
            ]
        );

        // Create a regular customer user
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Customer User',
                'username' => 'user',
                'role' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
            ]
        );
    }
}
