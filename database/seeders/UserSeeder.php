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
        User::unguard();

        User::firstOrCreate(
            ['email' => 'ampedig@gmail.com'],
            [
                'name' => 'Admin Ampedig',
                'password' => Hash::make('11223344'),
                'role' => 'admin',
            ]
        );

        User::reguard();
    }
}
