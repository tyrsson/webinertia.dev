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

namespace App;

use Mezzio\MiddlewareFactoryInterface;
use Mezzio\Router\RouteCollectorInterface;
use Mezzio\Router\RouteProviderInterface;

final class RouteProvider implements RouteProviderInterface
{
    public function registerRoutes(
        RouteCollectorInterface $routeCollector,
        MiddlewareFactoryInterface $middlewareFactory,
    ): void {
        $routeCollector->get(
            '/',
            $middlewareFactory->prepare(
                Handler\HomePageHandler::class
            ),
            'home'
        );
        $routeCollector->get(
            '/about',
            $middlewareFactory->prepare(
                Handler\AboutPageHandler::class
            ),
            'about'
        );
        $routeCollector->get(
            '/contact',
            $middlewareFactory->prepare(
                Handler\ContactPageHandler::class
            ),
            'contact'
        );
        $routeCollector->get(
            '/projects',
            $middlewareFactory->prepare(
                Handler\ProjectPageHandler::class
            ),
            'projects'
        );
        $routeCollector->get(
            '/services',
            $middlewareFactory->prepare(
                Handler\ServicePageHandler::class
            ),
            'services'
        );

        $routeCollector->get(
            '/ping',
            $middlewareFactory->prepare(
                Handler\PingHandler::class
            ),
            'api.ping'
        );
    }
}
