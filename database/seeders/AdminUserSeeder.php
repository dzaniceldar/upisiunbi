<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@unbi.ba'],
            [
                'name' => 'UNBI Admin',
                'role' => 'admin',
                'password' => Hash::make('Admin12345!'),
                'email_verified_at' => now(),
            ]
        );
    }
}
