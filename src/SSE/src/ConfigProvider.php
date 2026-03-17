<?php

declare(strict_types=1);

namespace Webware\SSE;

final readonly class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'router'       => $this->getRouteProviders(),
            'templates'    => $this->getTemplates(),
            SseStreamHandler::class => $this->getSseStreamHandlerConfig(),
        ];
    }

    /**
     * Returns the container dependencies.
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                SseStreamHandler::class => Container\SseStreamHandlerFactory::class,
                RouteProvider::class       => Container\RouteProviderFactory::class,
            ],
        ];
    }

    public function getRouteProviders(): array
    {
        return [
            'route-providers' => [
                RouteProvider::class,
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [
            'map'   => [
                'sse::info'    => __DIR__ . '/../templates/sse/info.phtml',
                'sse::message' => __DIR__ . '/../templates/sse/message.phtml',
                'sse::success' => __DIR__ . '/../templates/sse/success.phtml',
                'sse::warning' => __DIR__ . '/../templates/sse/warning.phtml',
                'sse::danger'  => __DIR__ . '/../templates/sse/danger.phtml',
            ],
            'paths' => [
                'sse'   => [__DIR__ . '/../templates/sse'],
                'error' => [__DIR__ . '/../templates/error'],
            ],
        ];
    }

    public function getSseStreamHandlerConfig(): array
    {
        return [
            'enable' => false,
            'url'    => '/sse-stream',
        ];
    }
}
