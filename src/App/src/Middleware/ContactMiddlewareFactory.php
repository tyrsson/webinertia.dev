<?php

declare(strict_types=1);

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
