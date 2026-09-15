<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@fixit.test'],
            [
                'name' => 'FixIT Administrator',
                'phone' => '0000000000',
                'password' => Hash::make(env('FIXIT_ADMIN_PASSWORD', 'change-me-please')),
                'role' => 'admin',
            ]
        );
    }
}