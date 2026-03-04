<?php

declare(strict_types=1);

use Axleus\Mailer\Adapter\AdapterInterface;
use Axleus\Mailer\MailerInterface;

return [
    MailerInterface::class => [
        AdapterInterface::class => [
            'to' => 'jsmith@webinertia.net',
        ],
    ],
];