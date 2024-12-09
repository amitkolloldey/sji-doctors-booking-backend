<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],  // You can limit the methods if needed

    // Add your allowed domains here:
    'allowed_origins' => [
        'http://localhost:3000',   // Replace with your domain
        'http://localhost:3001',
        'http://localhost:3002',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], 

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];