<?php

declare(strict_types=1);

namespace App\Listener;

use Axleus\Mailer\Event\MessageEvent;
use Override;
use Webware\CommandBus\Event\EventInterface;
use Webware\CommandBus\Event\ListenerInterface;

final class SendEmailCommandListener implements ListenerInterface
{
    public function __construct()
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function __invoke(EventInterface|MessageEvent $event): void
    {
        throw new \Exception('Not implemented');
    }
}
