<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
    'twitter' => [
        'consumer_key' => 'Ph0sLKmjak9hiE7itFpJf9VQZ',
        'consumer_secret' => 'WzEncUYFqyxWKo5me3zRzepRr7ku4k65teStP6ntbsUKPG7Gij',
        'access_token' => '1001170531704598529-PtObfeGs8kQ1XfhLEkLDKFlbfK6Iv9',
        'access_token_secret' => 'XlX8o3rmRRirWBwpUT2xHh2yfWG6KeJ6JMIQSzMUHneF3'
    ]
];
