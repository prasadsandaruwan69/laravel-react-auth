<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'user_id' => 'USR0001',
            'name' => 'Admin ',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

       

        
    }
}
