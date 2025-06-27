<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Options
    |--------------------------------------------------------------------------
    |
    | The allowed methods, origins, and headers are used for CORS requests.
    | You can specify * to allow any value.
    |
    */

    'supportsCredentials' => false,

    'allowedOrigins' => ['*'], // You can use ['http://localhost:3000'] for stricter access

    'allowedOriginsPatterns' => [],

    'allowedHeaders' => ['*'],

    'allowedMethods' => ['*'], // ex: ['GET', 'POST', 'PUT', 'DELETE']

    'exposedHeaders' => [],

    'maxAge' => 0,

];
