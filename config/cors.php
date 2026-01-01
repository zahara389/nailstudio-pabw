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

    // BAGIAN PENTING:
    // Saya tambahkan 'images/*' dan 'storage/*' agar folder foto tidak diblokir browser.
    'paths' => [
        'api/*', 
        'sanctum/csrf-cookie', 
        'images/*', 
        'storage/*'
    ],

    'allowed_methods' => ['*'],

    // BAGIAN PENTING:
    // Pakai bintang '*' agar bisa diakses dari IP LAN (192.168...) dan Port Flutter yang berubah-ubah.
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Tetap TRUE agar fitur login/session berjalan lancar.
    'supports_credentials' => true,

];