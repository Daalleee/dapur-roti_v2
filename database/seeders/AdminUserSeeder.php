<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        User::updateOrCreate(
            [
                'email' => 'admin@gmail.com',
            ],
            [
                'nama' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'no_hp' => '0828-9183-83',
                'alamat' => 'Weri',
                'role' => 'admin',
            ]
        );
    }
}
