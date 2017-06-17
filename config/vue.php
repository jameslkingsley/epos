<?php

return [
    'name' => config('app.name'),
    'url' => config('app.url'),
    'currency' => env('APP_CURRENCY'),
    'broadcasting' => config('broadcasting.connections.pusher')
];
