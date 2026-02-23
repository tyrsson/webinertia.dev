<?php

declare(strict_types=1);

namespace App\Container;

use App\Handler\ProjectPageHandler;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

final class ProjectPageHandlerFactory
{
    public function __invoke(ContainerInterface $container): ProjectPageHandler
    {
        $template = $container->get(TemplateRendererInterface::class);
        return new ProjectPageHandler($template);
    }
}
