<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['badge_number' => 'ADMIN001'], // unique badge
            [
                'first_name' => 'System',
                'last_name'  => 'Administrator',
                'name'       => 'System Administrator',
                'email'      => 'admin@army.local',
                'password'   => Hash::make('Admin@12345'),
                'division'   => 'Command',
                'role'       => 1, // Admin
                'last_login_at'=> now(),
            ]
        );
    }
}
