<?php

declare(strict_types=1);

namespace App\Middleware;

use Axleus\Mailer\CommandBus\SendEmailCommand;
use Axleus\mailer\Event\MessageEvent;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Webware\CommandBus\CommandBusInterface;

final readonly class ContactMiddleware implements MiddlewareInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private array $config
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = $request->getParsedBody();
        $this->commandBus->handle(new SendEmailCommand(
            to: $this->config['to'] ?? 'contact@example.com',
            subject: 'New Contact Form Submission',
            body: sprintf(
                "Name: %s %s\nEmail: %s\nPhone: %s\nCompany: %s\nService Needed: %s\nBudget Range: %s\nProject Details: %s",
                $data['firstname'] ?? '',
                $data['lastname'] ?? '',
                $data['email'] ?? '',
                $data['phone'] ?? '',
                $data['company'] ?? '',
                $data['service'] ?? '',
                $data['budget'] ?? '',
                $data['message'] ?? ''
            ),
            event: new MessageEvent()
        ));
        // Middleware logic goes here
        return $handler->handle($request);
    }
}
