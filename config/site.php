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
    | Back to Us founding offer
    |--------------------------------------------------------------------------
    */

    'founding' => [
        'price' => '₹4,999',
        'spots' => 5,
        'spots_left' => 5,
    ],

];
