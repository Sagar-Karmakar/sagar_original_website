<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Free call booking
    |--------------------------------------------------------------------------
    |
    | Weekly hours and days off are set in /admin/availability. These are the
    | rules every slot follows. Times are shown to visitors in this timezone
    | and stored in UTC.
    |
    */

    'timezone' => 'Asia/Kolkata',

    // Length of the call, and how often a new slot starts (the rest is a gap between calls).
    'duration' => 20,
    'interval' => 30,

    // Earliest a call can be booked, in hours from now, and how far ahead the calendar shows.
    'min_notice' => 4,
    'days_ahead' => 21,

    'languages' => ['English', 'Hindi or Hinglish', 'Bengali'],

    // Video call link sent with every booking (Google Meet, Zoom...). Leave empty to send it on WhatsApp yourself.
    'meeting_url' => env('BOOKING_MEETING_URL'),

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    |
    | New bookings and cancellations are emailed to notify_email, and posted
    | to the Discord channel behind the webhook when one is set.
    |
    */

    // An empty BOOKING_NOTIFY_EMAIL falls back to SITE_EMAIL
    'notify_email' => env('BOOKING_NOTIFY_EMAIL') ?: env('SITE_EMAIL', 'contact@sagarkarmakar.com'),
    'discord_webhook' => env('DISCORD_BOOKING_WEBHOOK'),

];
