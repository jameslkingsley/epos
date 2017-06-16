<?php

return [
    'name' => config('app.name'),
    'url' => config('app.url'),
    'currency' => env('APP_CURRENCY'),

    'company' => [
        'name' => env('COMPANY_NAME', 'EPOS'),
        'vat_number' => env('COMPANY_VATNUMBER', '123 456 789')
    ]
];
