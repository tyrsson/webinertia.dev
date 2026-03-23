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
use Htmx\TriggerTrait;
use Laminas\Diactoros\Response;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Webware\CommandBus\Command\CommandResult;
use Webware\CommandBus\Command\CommandStatus;

use function strtolower;

final class PageHandler implements RequestHandlerInterface
{
    use TriggerTrait;

    protected array $headers = [];

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

        $status = $commandResult->getStatus() === CommandStatus::Success;
        $this->htmxTrigger(
            [
                'message' => $status
                    ? 'Your message has been sent successfully.'
                    : 'There was an error sending your message. Please try again later.',
                'level' => $status
                        ? strtolower(MessageLevel::Success->value)
                        : strtolower(MessageLevel::Warning->value),
                ],
            );

         return new Response\HtmlResponse(
            html: $this->template->render('app::contact-page', $data),
            headers: $this->headers
        );
    }
}
