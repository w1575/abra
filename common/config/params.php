<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'imageUploaderBehavior' => [
        'webPath' => '//abra-static.loc/',
        'folderPath' => '@static/',
        'namePrefixLength' => 12,
        'previewSettings' => [
            'width' => 250,
            'height' => 120,
            'quality' => 90,
            'prefixName' => 'thumb_',
            'folder' => 'preview',
        ],
    ],
];
