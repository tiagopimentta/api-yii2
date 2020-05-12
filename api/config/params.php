<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'jwt' => [
        'secret' => 'da39a3ee5e6b4b0d3255bfef95601890afd80709',
        'algorithm' => 'HS256',
        'expiration' => 3600 // 1 hour (in seconds)
    ]
];
