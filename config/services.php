<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'vkontakte' => [
        'client_id' => env('VK_CLIENT_ID'),
        'client_secret' => env('VK_CLIENT_SECRET'),
        'redirect' => env('VK_REDIRECT_URI'),
    ],

    'vk' => [
        'service_token' => env('VK_SERVICE_TOKEN'),
        'group_id' => env('VK_GROUP_ID'),

        'order_token' => env('VK_GROUP_ORDER_TOKEN'),
        'order_group_id' => env('VK_GROUP_ORDER_ID'),
        'send_to_id1' => env('SENDVK_TO1',0),
        'send_to_id2' => env('SENDVK_TO2',0),
        'send_to_id3' => env('SENDVK_TO3',0),
        'send_to_id4' => env('SENDVK_TO4',0),
        'send_to_id5' => env('SENDVK_TO5',0),
        'send_to_id6' => env('SENDVK_TO6',0),
        'send_to_id7' => env('SENDVK_TO7',0),
        'send_to_id8' => env('SENDVK_TO8',0),
        'send_to_id9' => env('SENDVK_TO9',0),
        'send_to_id10' => env('SENDVK_TO10',0),
    ],

];
