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

namespace App\Middleware;

use Axleus\Mailer\MailerInterface;
use Psr\Container\ContainerInterface;
use Webware\CommandBus\CommandBusInterface;

final readonly class ContactMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): ContactMiddleware
    {
        $commandBus = $container->get(CommandBusInterface::class);

        return new ContactMiddleware(
            $commandBus,
            $container->get('config')[MailerInterface::class] ?? []
        );
    }
}
