<?php

declare(strict_types=1);

use Axleus\Mailer\Adapter\MessageInterface;
use Axleus\Mailer\MailerInterface;

return [
    MessageInterface::class => [
        'to'      => 'jsmith@webinertia.net',
        'from'    => 'contact@webinertia.dev',
        'subject' => 'Webinertia Project Request',
    ],
    'view_helper_config' => [
        'asset' => [
            'resource_map' => [
                'debug.js'    => 'assets/js/debug.js',
                'notify.js'   => 'assets/js/system.messenger.js',
            ],
        ],
    ],
];