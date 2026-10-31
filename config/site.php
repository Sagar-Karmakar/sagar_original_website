<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Contact
    |--------------------------------------------------------------------------
    |
    | Where the site's contact links point. Booking settings are in
    | config/booking.php.
    |
    */

    'whatsapp_url' => 'https://wa.me/'.env('SITE_WHATSAPP_NUMBER', '916291373748'),
    'email' => env('SITE_EMAIL', 'contact@sagarkarmakar.com'),
    'instagram_url' => 'https://www.instagram.com/sagarforcouples/',

    /*
    |--------------------------------------------------------------------------
    | Admin login
    |--------------------------------------------------------------------------
    |
    | `php artisan admin:create` (with no email) and `php artisan db:seed`
    | create the /admin login from these. On the live server, remove the
    | password from .env once the login exists.
    |
    */

    'admin' => [
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Back to Us offer
    |--------------------------------------------------------------------------
    |
    | Starting values only: change them in Admin → Offer. Leave spots_total
    | empty there to stop showing spots.
    |
    */

    'offer' => [
        'label' => 'Founding couples',
        'price' => 4999,
        'spots_total' => 5,
        'spots_left' => 5,
        'note_title' => 'Why so low?',
        'note' => 'You’d be one of my first couples, and I’ll ask for your honest feedback in return. After that, the price goes up.',
    ],

];
