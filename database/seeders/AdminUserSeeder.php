<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'michael@keystoneuoa.com'],
            [
                'name' => 'Michael Admin',
                'email' => 'michael@keystoneuoa.com',
                'password' => Hash::make('805011Mic'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}
