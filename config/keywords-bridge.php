<?php

return [
    'default' => env('KEYWORDS_DRIVER', 'none'),

    'drivers' => [
        'google' => [
            'version' => env('GOOGLEADS_VERSION', 'v26'),
            'customer' => env('GOOGLEADS_CUSTOMER_ID'),
            'login' => env('GOOGLEADS_LOGIN_CUSTOMER_ID'),
            'token' => env('GOOGLEADS_DEVELOPER_TOKEN'),
            'client' => env('GOOGLEADS_CLIENT_ID'),
            'secret' => env('GOOGLEADS_CLIENT_SECRET'),
            'refresh' => env('GOOGLEADS_REFRESH_TOKEN'),
        ],
        'ahrefs' => [
            'key' => env('AHREFS_API_KEY'),
            'country' => env('AHREFS_COUNTRY', 'us'),
        ],
        'semrush' => [
            'key' => env('SEMRUSH_API_KEY'),
            'database' => env('SEMRUSH_DATABASE', 'us'),
        ],
    ],
];
