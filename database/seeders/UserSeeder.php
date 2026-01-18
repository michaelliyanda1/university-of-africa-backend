<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Michael Admin',
                'email' => 'michael@keystoneuoa.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '+260 123 456 789',
                'bio' => 'System Administrator',
                'is_active' => true,
            ],
            [
                'name' => 'John Staff',
                'email' => 'john.staff@uoa.edu',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'phone' => '+260 987 654 321',
                'bio' => 'Academic Staff Member',
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Student',
                'email' => 'sarah.student@uoa.edu',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'phone' => '+260 555 123 456',
                'bio' => 'Computer Science Student',
                'is_active' => true,
            ],
            [
                'name' => 'David Researcher',
                'email' => 'david.researcher@uoa.edu',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'phone' => '+260 555 789 012',
                'bio' => 'Research Coordinator',
                'is_active' => true,
            ],
            [
                'name' => 'Emily Public',
                'email' => 'emily.public@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'public',
                'phone' => '+260 555 345 678',
                'bio' => 'Public User',
                'is_active' => true,
            ],
            [
                'name' => 'James Inactive',
                'email' => 'james.inactive@uoa.edu',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'phone' => '+260 555 901 234',
                'bio' => 'Inactive Student Account',
                'is_active' => false,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Users seeded successfully!');
    }
}
