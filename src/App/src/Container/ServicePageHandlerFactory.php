<?php

declare(strict_types=1);

namespace App\Container;

use App\Handler\ServicePageHandler;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

final class ServicePageHandlerFactory
{
    public function __invoke(ContainerInterface $container): ServicePageHandler
    {
        $template = $container->get(TemplateRendererInterface::class);
        return new ServicePageHandler($template);
    }
}
