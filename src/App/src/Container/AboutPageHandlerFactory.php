<?php

declare(strict_types=1);

namespace App\Container;

use App\Handler\AboutPageHandler;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

final class AboutPageHandlerFactory
{
    public function __invoke(ContainerInterface $container): AboutPageHandler
    {
        $template = $container->get(TemplateRendererInterface::class);
        return new AboutPageHandler($template);
    }
}
