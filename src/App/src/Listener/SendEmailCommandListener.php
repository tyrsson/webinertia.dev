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

namespace App\Listener;

use Axleus\Mailer\Event\MessageEvent;
use Exception;
use Override;
use Webware\CommandBus\Event\EventInterface;
use Webware\CommandBus\Event\ListenerInterface;

final class SendEmailCommandListener implements ListenerInterface
{
    public function __construct()
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function __invoke(EventInterface|MessageEvent $event): void
    {
        throw new Exception('Not implemented');
    }
}
