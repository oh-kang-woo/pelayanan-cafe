<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Waiter
        User::create([
            'name' => 'Waiter',
            'email' => 'waiter@example.com',
            'password' => Hash::make('waiter123'),
            'role' => 'waiter',
        ]);

        // Kasir
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@example.com',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
        ]);

        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Barista
        User::create([
            'name' => 'Barista',
            'email' => 'barista@example.com',
            'password' => Hash::make('barista123'),
            'role' => 'barista',
        ]);
    }
}
