# Webinertia.dev - Copilot Instructions

## Project Overview

**webinertia.dev** is a Mezzio 3 web framework application for Webinertia, a software development company specializing in Mezzio and Laminas frameworks.

- **Language**: PHP 8.2, 8.3, 8.4, 8.5
- **Type**: Custom Mezzio Application / Corporate Website
- **Framework Stack**: Mezzio 3, Laminas ServiceManager, FastRoute
- **Key Features**: Bleeding-edge dependencies, PHPStan level 10 analysis, Pico CSS framework, HTMX integration

## Architecture & Standards

### PSR Compliance
- **PSR-4**: Autoloading with namespace root `App\` mapping to `src/App/src/`
- **PSR-1/PSR-12/PER-3**: PHP coding standards (enforced via php-cs-fixer) and webware coding standard
- **PSR-7**: HTTP message interfaces via Laminas Diactoros
- **PSR-11**: Container Interface for dependency injection. Laminas ServiceManager is used as the container implementation.
- **PSR-15**: HTTP Server Request Handlers and Middleware. All handlers implement `Psr\Http\Server\RequestHandlerInterface`.

### Directory Structure

```
src/App/src/
├── ConfigProvider.php          # App configuration and service definitions
├── RouteProvider.php           # Route registration handler
├── Container/                  # Factory classes for dependency injection
│   ├── AboutPageHandlerFactory.php
│   ├── ContactPageHandlerFactory.php
│   ├── HomePageHandlerFactory.php
│   ├── ProjectPageHandlerFactory.php
│   ├── RouteProviderFactory.php
│   └── ServicePageHandlerFactory.php
└── Handler/                    # Request handlers
    ├── HomePageHandler.php
    ├── AboutPageHandler.php
    ├── ContactPageHandler.php
    ├── ProjectPageHandler.php
    ├── ServicePageHandler.php
    └── PingHandler.php

src/App/templates/             # Template files (Laminas View)
├── app/
│   ├── home.phtml
│   ├── about-page.phtml
│   ├── contact-page.phtml
│   ├── projects.phtml
│   ├── services.phtml
│   └── ping.phtml
└── layout/
    └── default.phtml

config/
├── config.php                  # Main config aggregator
├── container.php               # Container configuration
├── development.config.php      # Development-specific config
├── pipeline.php                # Middleware pipeline setup
└── autoload/                   # Auto-loaded configuration files
    ├── dependencies.global.php
    ├── global.php
    ├── mezzio.global.php
    ├── mysql.local.php
    └── tracy.global.php
```

### Core Patterns & Conventions

#### 1. Factory Pattern
All handlers use factory classes from `App\Container\` namespace:

```php
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
```

#### 2. Handler Structure
Request handlers accept `TemplateRendererInterface` and implement PSR-15 `RequestHandlerInterface`:

```php
namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class AboutPageHandler implements RequestHandlerInterface
{
    public function __construct(private TemplateRendererInterface $template) {}
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Handler implementation
    }
}
```

#### 3. Route Registration
Routes are registered via `RouteProvider` implementing `RouteProviderInterface`:

```php
public function registerRoutes(
    RouteCollectorInterface $routeCollector,
    MiddlewareFactoryInterface $middlewareFactory,
): void {
    $routeCollector->route(
        'route_name',
        '/path',
        [Handler\NameHandler::class],
        ['GET'],
        'route_name',
    );
}
```

#### 4. Configuration Registration
The `ConfigProvider` defines dependencies and templates:

```php
public function getDependencies(): array
{
    return [
        'factories' => [
            Handler\NameHandler::class => Container\NameHandlerFactory::class,
        ],
    ];
}
```

## Development Workflow

### Composer Scripts

```bash
# Run all checks
composer check

# Code style checking
composer cs-check

# Code style fixing
composer cs-fix

# Static analysis
composer sa                    # PHPStan level 10
composer sa-gen-baseline       # Generate PHPStan baseline
composer sa-verbose            # Verbose analysis

# Clear config cache
composer clear-config-cache

# Testing
composer test                  # Run PHPUnit tests
composer test-coverage         # Generate coverage report
```

### Quality Assurance Standards

- **Static Analysis**: PHPStan level 10 (configured in `phpstan.neon.dist`)
  - No baseline required (passes cleanly)
  - Includes stub files for Laminas ServiceManager and PSR Container
  
- **Code Style**: PHP CS Fixer (Webware coding standard)
  - Configuration inherited from `webware/coding-standard`
  
- **Testing**: PHPUnit with strict configuration
  - Bootstrap: `vendor/autoload.php`
  - Coverage metadata required
  - Fails on notices, deprecations, and warnings
  - Test directory: `test/`

## Key Dependencies

### Core Framework
- `mezzio/mezzio` ^3.26 - HTTP middleware application framework
- `mezzio/mezzio-fastroute` ^3.14 - FastRoute adapter
- `mezzio/mezzio-laminasviewrenderer` ^3.0 - Template rendering
- `mezzio/mezzio-helpers` ^5.20 - Request/response helpers
- `laminas/laminas-servicemanager` ^4.5 - Service locator
- `laminas/laminas-view` ^3.0 - View layer

### Database & Utilities
- `php-db/phpdb-mysql` ^0.2.0 - MySQL database access
- `webware/command-bus` ^0.4.0 - CQRS command bus
- `laminas/laminas-translator` - Internationalization support

### Development Tools
- `phpstan/phpstan` ^2.1 - Static analysis
- `phpunit/phpunit` ^11.5.42 - Testing framework
- `webware/coding-standard` ^0.1.0 - Code style standard
- `webware/traccio` ^0.1.0 - Debugging/development tool

## Code Guidelines

### Naming Conventions
- **Namespaces**: `App\*` (handlers, factories, services)
- **Classes**: PascalCase (e.g., `AboutPageHandler`)
- **Factories**: `{ServiceName}Factory` pattern
- **Methods**: camelCase
- **Variables**: camelCase
- **Constants**: SCREAMING_SNAKE_CASE

### PHP Version
- Target: PHP 8.2.99 (configured as platform in composer.json)
- Features used: Typed properties, match expressions, named arguments
- Type hints are mandatory on all public methods

### File Structure
- One class per file
- `declare(strict_types=1);` at file top
- Namespace declaration followed by imports
- No inline implementation in factories

### Best Practices
1. **Dependency Injection**: Only use constructor injection via factories
2. **Type Hints**: All parameters and returns must be typed
3. **Final Classes**: Classes should be `final` unless designed for extension
4. **Error Handling**: Use proper exception handling, not silent failures
5. **Templates**: Use `.phtml` extension; implement proper HTML escaping
6. **Routes**: Use named routes; define in `RouteProvider`
7. **Immutability**: Prefer immutable patterns where possible

## Template Engine

- **Engine**: Laminas View (View abstraction)
- **Format**: `.phtml` (PHP HTML templates)
- **Location**: `src/App/templates/`
- **Layout**: `default.phtml` in `layout/` subdirectory
- **Body**: Rendered via `$this->body` in layout, and provided by `src/Htmx/templates/body/default.phtml` to provide an additional layer to support HTMX boosting.
- **CSS Framework**: Bootstrap 5.3 with custom dark glassmorphic styles in `assets/css/style.css`
- **JavaScript**: HTMX (loaded from CDN)

### Template Usage
```php
$template->render('app::{page-name}', ['variable' => $value]);
```

## Configuration Management

- **Aggregator**: `Laminas\ConfigAggregator` with caching
- **Cache Path**: `data/cache/config-cache.php`
- **Load Order**: Global → Local → Development
- **Key Providers**: 
  - Framework configs from Mezzio/Laminas
  - App config from `ConfigProvider`
  - Local configs from `config/autoload/`

## Common Tasks

### Adding a New Page Handler
1. Create handler class in `src/App/src/Handler/{Name}PageHandler.php`
2. Create factory in `src/App/src/Container/{Name}PageHandlerFactory.php`
3. Register in `src/App/src/ConfigProvider.php` (factories and route providers)
4. Register route in `src/App/src/RouteProvider.php`
5. Create template in `src/App/templates/app/{name}-page.phtml`
6. Run `composer check` to validate

### Adding a Service/Dependency
1. Create service class with proper type hints
2. Create factory if needed (dependencies required)
3. Register in `ConfigProvider` under 'factories' or 'invokables'
4. Inject into handlers via constructor

### Running Tests
1. Create test class in `test/AppTest/` mirroring src structure
2. Use `InMemoryContainer` from test utilities for DI
3. Run `composer test` to execute
4. Check coverage with `composer test-coverage`

## Performance & Optimization

- **Config Caching**: Enabled in production (disabled in development)
- **Debug Mode**: Configurable via `ConfigAggregator::ENABLE_CACHE`
- **Database**: MySQL with direct access layer (`phpdb/phpdb-mysql`)
- **Front-end**: HTMX + Bootstrap 5.3 with custom dark glassmorphic styles in `assets/css/style.css`

## Development Considerations

- **Bleeding-Edge**: Uses latest stable releases of dependencies
- **No Whoops**: Unlike standard Mezzio skeleton
- **Tracy Debugger**: Optional via `webware/traccio` when present
- **Command Bus**: Middleware driven architecture available via `webware/command-bus`
- **Strict Mode**: All errors/warnings/deprecations fail tests

## Debugging & Logging

- **Static Analysis**: Run `composer sa-verbose` for detailed PHPStan output
- **Development Tools**: Tracy debugger available if package installed
- **Config Cache**: Clear with `composer clear-config-cache`
- **Error Display**: Controlled via development.config.php
- **Development mode disabled by**: First replace the contents of `development.config.php.dist` with `development.config.php` then rename back to `development.config.php.dist`

## Version Information
- **Current Branch**: 0.1.x
- **PHP Support**: 8.2 - 8.5
- **License**: BSD-3-Clause
- **Author**: Joey Smith <jsmith@webinertia.net>

## Related Resources
- Mezzio Documentation: https://docs.mezzio.dev/
- Laminas Project: https://www.laminas.dev/
- FastRoute: https://github.com/nikic/FastRoute
- PHPUnit: https://phpunit.de/
- PHPStan: https://phpstan.org/
- PhpDb: https://github.com/php-db/phpdb/tree/0.6.x/docs/book
- PhpDb MySQL Adapter: https://github.com/php-db/phpdb-mysql/tree/0.4.x/docs/book
- Webware Coding Standard: https://github.com/tyrsson/coding-standard
- Webware Command Bus: https://github.com/tyrsson/command-bus/tree/0.5.x/docs
- Webware Traccio: https://github.com/tyrsson/traccio
- Axleus Mailer: https://github.com/axleus/axleus-mailer
- Axleus Message: https://github.com/axleus/axleus-message
