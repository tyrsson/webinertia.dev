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

use Axleus\Message\MessageLevel;
use Axleus\Message\SystemMessengerInterface;
use Laminas\Diactoros\Response;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Webware\CommandBus\Command\CommandResult;
use Webware\CommandBus\Command\CommandStatus;

final class PageHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ?TemplateRendererInterface $template = null,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = [
            'title' => 'Contact Us',
        ];
        $commandResult = $request->getAttribute(CommandResult::class);
        $messenger     = $request->getAttribute(SystemMessengerInterface::class);

        if ($commandResult === null) {
            return new Response\HtmlResponse($this->template->render('app::contact-page', $data));
        }

        if ($commandResult->getStatus() === CommandStatus::Success) {
            $messenger?->sendNow(
                'Your message has been sent. We will be in touch shortly.',
                MessageLevel::Success,
            );
        }

        $messenger?->sendNow(
            'There was a problem sending your message. Please try again.',
            MessageLevel::Danger,
        );

         return new Response\HtmlResponse($this->template->render('app::contact-page', $data));
    }
}
