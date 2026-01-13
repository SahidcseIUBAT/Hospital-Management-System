<?php

return [
    'store_id'       => env('SSLCOMMERZ_STORE_ID'),
    'store_password' => env('SSLCOMMERZ_STORE_PASSWORD'),
    'sandbox'        => env('SSLCOMMERZ_SANDBOX', true),

    'sandbox_url' => 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php',
    'live_url'    => 'https://securepay.sslcommerz.com/gwprocess/v4/api.php',
];
