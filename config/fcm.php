<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAArPXAgwc:APA91bE4iPItipwhm3piB5ykiKu9S18WDQtRLDY_n4SKuEDrq8_D4kojmRHVseoAWey6BKgzYBIUiIxCaUzQIdwUhi9Ces3tKs2y6QUqao0wkwaWstQl_CynPjjNBlqgXk9rCvkTUUAU'),
        'sender_id' => env('FCM_SENDER_ID', '742857409287'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'server_topic_url' => 'https://iid.googleapis.com/iid/v1/',
        'timeout' => 30.0, // in second
    ],
];
