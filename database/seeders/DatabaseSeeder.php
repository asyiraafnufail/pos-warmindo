<?php

namespace database\seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Superadmin Warmindo',
            'email' => 'admin@warmindo.com',
            'password' => Hash::make('12345678'), // Password di-hash kuat
            'is_superadmin' => true, // Diberi akses penuh
        ]);
    }
}