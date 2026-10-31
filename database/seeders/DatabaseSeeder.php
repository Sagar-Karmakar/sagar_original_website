<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // The /admin login, from ADMIN_EMAIL and ADMIN_PASSWORD in .env
        ['email' => $email, 'password' => $password] = config('site.admin');

        if ($email && $password) {
            User::updateOrCreate(['email' => $email], ['name' => 'Sagar Karmakar', 'password' => $password]);
        }
    }
}
