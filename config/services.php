<?php

return [
    'payments' => [
        'common' => App\Basket\Payments\Services\Common::class,
        'stripe' => App\Basket\Payments\Services\Stripe::class,
        'worldpay' => App\Basket\Payments\Services\WorldPay::class,
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ]
];
