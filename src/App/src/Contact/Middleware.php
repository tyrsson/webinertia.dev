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

use Axleus\Mailer\CommandBus\SendEmailCommand;
use Axleus\mailer\Event\MessageEvent;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Webware\CommandBus\CommandBusInterface;
use Webware\CommandBus\Command\CommandResult;

final readonly class Middleware implements MiddlewareInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private array $config,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data   = $request->getParsedBody();
        $result = $this->commandBus->handle(new SendEmailCommand(
            to: $this->config['to'] ?? 'contact@webinertia.dev',
            from: $this->config['from'] ?? 'no-reply@example.com',
            subject: $this->config['subject'] ?? 'Webinertia Contact Form Submission',
            body: sprintf(
                "Name: %s %s\nEmail: %s\nPhone: %s\nCompany: %s\nService Needed: %s\nBudget Range: %s\nProject Details: %s",
                $data['firstname'] ?? '',
                $data['lastname']  ?? '',
                $data['email']     ?? '',
                $data['phone']     ?? '',
                $data['company']   ?? '',
                $data['service']   ?? '',
                $data['budget']    ?? '',
                $data['message']   ?? ''
            ),
            event: new MessageEvent()
        ));

        // Middleware logic goes here
        return $handler->handle($request->withAttribute(CommandResult::class, $result));
    }
}
