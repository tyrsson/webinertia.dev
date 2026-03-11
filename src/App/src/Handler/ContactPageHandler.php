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

namespace App\Handler;

use Laminas\Diactoros\Response;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Webware\CommandBus\Command\CommandResult;
use Webware\CommandBus\Command\CommandStatus;

final class ContactPageHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ?TemplateRendererInterface $template = null,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = [
            'title'         => 'Contact Us',
            'hero-subtitle' => 'From concept to deployment, we deliver comprehensive solutions that drive results',
        ];
        $commandResult = $request->getAttribute(CommandResult::class);
        if ($commandResult === null) {
            return new Response\HtmlResponse($this->template->render('app::contact-page', $data));
        }
        return match ($commandResult->getStatus()) {
            CommandStatus::Success => new Response\HtmlResponse($this->template->render('app::contact-page', $data)),
            default => new Response\HtmlResponse($this->template->render('error::error', $data)),
        };
    }
}
