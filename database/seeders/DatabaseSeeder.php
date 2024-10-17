<?php

namespace Database\Seeders;

use App\Models\Tenants;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'test ken',
            'email' => 'kenmutesh901@gmail.com',
            'password' => Hash::make('12345678')
        ]);

    }
}
