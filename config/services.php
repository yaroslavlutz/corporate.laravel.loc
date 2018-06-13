<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

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
    ],
    'google' => [
        'client_id' => env('GOOGLE_APP_ID'),         //Your Google Client ID
        'client_secret' => env('GOOGLE_APP_SECRET'), //Your Google Client Secret
        'redirect' => 'http://corporate.laravel.dev/login/google/callback', //но у меня на локалке домен `laravel.loc`, но окончание `loc` Google не примет,ему нужен общедоступный домен типа `org`,`com` или даже `dev`, котрорый как раз лучше использовать при разработке и на локальной машине
    ], //http://corporate.laravel.com/auth/google/callback

    'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID'),         //Your Facebook Client ID
        'client_secret' => env('FACEBOOK_APP_SECRET'), //Your Facebook Client Secret
        'redirect' => 'https://corporate.laravel.loc/login/facebook/callback', //но у меня на локалке протокол `http`, но окончание `http` Facebook не примет,ему нужен `https`
    ],

];
