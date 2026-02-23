<?php

declare(strict_types=1);

namespace App\Container;

use App\Handler\ContactPageHandler;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

final class ContactPageHandlerFactory
{
    public function __invoke(ContainerInterface $container): ContactPageHandler
    {
        $template = $container->get(TemplateRendererInterface::class);
        return new ContactPageHandler($template);
    }
}
