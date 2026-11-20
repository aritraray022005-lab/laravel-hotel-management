<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Hotel details
    |--------------------------------------------------------------------------
    |
    | Shown on the public site (header, about, contact and footer). Override
    | them in your .env file instead of editing the views.
    |
    */

    'name' => env('HOTEL_NAME', 'Grand Stay Hotel'),
    'tagline' => env('HOTEL_TAGLINE', 'Comfortable rooms, warm hospitality.'),
    'address' => env('HOTEL_ADDRESS', '12 Park Street, Kolkata, West Bengal'),
    'phone' => env('HOTEL_PHONE', '+91 00000 00000'),
    'email' => env('HOTEL_EMAIL', 'hello@example.com'),
    'currency' => env('HOTEL_CURRENCY', '$'),

    /*
    |--------------------------------------------------------------------------
    | Seeded administrator
    |--------------------------------------------------------------------------
    |
    | Used only by `php artisan db:seed`. Change the password before the app
    | is reachable from the internet.
    |
    */

    'admin' => [
        'name' => env('ADMIN_NAME', 'Administrator'),
        'email' => env('ADMIN_EMAIL', 'admin@example.com'),
        'password' => env('ADMIN_PASSWORD', 'password'),
    ],

];
