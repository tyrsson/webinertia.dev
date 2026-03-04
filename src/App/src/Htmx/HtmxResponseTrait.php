<?php

declare(strict_types=1);

namespace App\Htmx;

use App\Htmx\ResponseHeaders as Header;

use function json_encode;

trait HtmxResponseTrait
{
    use HtmxTriggerTrait;

    private array $allowedKeys = [
        ''
    ];

    public function htmxLocation(string $path, ?string $target = null): void
    {
        if ($target !== null) {
            $this->headers[Header::HX_Location->value] = json_encode(['path' => $path, 'target' => $target]);
            return;
        }
        $this->headers[Header::HX_Location->value] = $path;
    }
}
