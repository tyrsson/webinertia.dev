<?php

declare(strict_types=1);

namespace App\Middleware;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

final class NotificationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): NotificationMiddleware
    {
        $template = $container->get(TemplateRendererInterface::class);
        return new NotificationMiddleware($template);
    }
}

