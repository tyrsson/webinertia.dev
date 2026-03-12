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

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

final class PageHandlerFactory
{
    public function __invoke(ContainerInterface $container): PageHandler
    {
        $template = $container->get(TemplateRendererInterface::class);

        return new PageHandler($template);
    }
}
