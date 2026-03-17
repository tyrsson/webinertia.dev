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

namespace Webware\SSE;

use Axleus\Message\SystemMessengerInterface;
use Laminas\View\Helper\Partial;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class SseStreamHandler implements RequestHandlerInterface
{
    public const EVENT_CLOSE = 'sse-close';

    public function __construct(
        private readonly Partial $partialHelper,
        private readonly array $config = [],
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (! ($this->config['enable'] ?? false)) {
            return new SseResponse(new Event('', self::EVENT_CLOSE)->format());
        }

        $lastEventId = $request->getHeaderLine('ID');

        $messenger = $request->getAttribute(SystemMessengerInterface::class);

        if (! $messenger?->hasMessages()) {
            return new SseResponse(new Event(
                data: ': keep-alive',
            )->format());
        }
        
        foreach ($messenger?->getMessages() as $level => $message) {
            $html = ($this->partialHelper)('sse::'.$message['key'], [
                'level'   => $message['key'],
                'message' => $message['message'],
            ]);

            $eventStream = new Event(
                data: $html,
                event: $message['key'],
            )->format();
        }

        return new SseResponse($eventStream);
    }
}
