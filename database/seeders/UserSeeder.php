<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin HelpDesk',
            'email' => 'admin@helpdeskku.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Agent HelpDesk',
            'email' => 'agent@helpdeskku.test',
            'password' => Hash::make('password'),
            'role' => 'agent',
        ]);

        User::create([
            'name' => 'User HelpDesk',
            'email' => 'user@helpdeskku.test',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}