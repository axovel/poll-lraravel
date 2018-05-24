<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_KEY'),
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
    ],

    'facebook' => [
        'client_id' => '171566069944845',
        'client_secret' => '5d0575f4f3b8cf4fd6a713aec6fc1f02',
        'redirect' => 'http://192.241.153.62/kansanaani/public/auth/facebook',
    ],

    'google' => [
        'client_id' => '188800503049-hmri2pkle2n86o0ni8lna7gsvnkorb1k.apps.googleusercontent.com',
        'client_secret' => 'vHQM_-noccZDDJ-LHMcWwEcF',
        'redirect' => 'http://192.241.153.62/kansanaani/public/auth/google',
    ],

];
