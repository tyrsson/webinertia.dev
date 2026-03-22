<?php

declare(strict_types=1);

namespace App\Middleware;

use Axleus\Message\MessageLevel;
use Axleus\Message\SystemMessengerInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class NotificationMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TemplateRendererInterface $template
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $messenger = $request->getAttribute(SystemMessengerInterface::class);
        
        $messages = $messenger?->getMessages() ?? [];
        
        $this->template->addDefaultParam(
            TemplateRendererInterface::TEMPLATE_ALL,
            'notification',
            ['message' => $messages, 'delay' => 5000]
        );
        // Middleware logic goes here
        return $handler->handle($request);
    }
}
