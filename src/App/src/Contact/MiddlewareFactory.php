<?php

declare(strict_types=1);

/**
 * This file is part of the Tyrsson Webinertia package.
 *
 * Copyright (c) 2026 Joey Smith <jsmith@webinertia.net>
 * and contributors.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Contact;

use Axleus\Mailer\MailerInterface;
use Axleus\Mailer\Adapter\MessageInterface;
use Psr\Container\ContainerInterface;
use Webware\CommandBus\CommandBusInterface;

final readonly class MiddlewareFactory
{
    public function __invoke(ContainerInterface $container): Middleware
    {
        $commandBus = $container->get(CommandBusInterface::class);

        return new Middleware(
            $commandBus,
            $container->get('config')[MessageInterface::class] ?? []
        );
    }
}
