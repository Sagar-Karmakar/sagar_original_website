<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:create {email} {--name=Sagar Karmakar}', function (string $email) {
    $password = $this->secret('Choose a password (at least 10 characters)');

    if (strlen((string) $password) < 10) {
        $this->error('The password needs at least 10 characters. Nothing was saved.');

        return 1;
    }

    User::updateOrCreate(['email' => $email], ['name' => $this->option('name'), 'password' => $password]);

    $this->info("Done. Log in at ".route('login')." with {$email}.");
})->purpose('Create the admin login for /admin, or reset its password');
