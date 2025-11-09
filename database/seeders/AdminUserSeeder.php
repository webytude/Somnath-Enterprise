<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if a user with the admin email already exists to prevent duplicates
        if (! User::where('email', 'admin@gmail.com')->exists()) {
            
            User::create([
                'name'              => 'Super Admin',
                'email'             => 'admin@gmail.com',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'is_staff'          => true,
                'phone'             => '1234567890',
                'dob'               => '1990-01-01',
                'e_phone'   => '7894561230',
                'address'           => '123 Admin Street, City, Country',
            ]);
        }
    }
}