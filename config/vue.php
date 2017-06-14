<?php

return [
    'name' => config('app.name'),
    'url' => config('app.url'),
    'currency' => env('APP_CURRENCY'),

    'printers' => [
        'star_web_print' => [
            'ip' => env('PRINTER_STARWEBPRINT_IP', ''),
            'port' => env('PRINTER_STARWEBPRINT_PORT', '')
        ]
    ]
];
