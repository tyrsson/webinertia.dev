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

namespace App\Htmx;

use App\Htmx\ResponseHeaders as Header;

use function json_encode;

trait HtmxResponseTrait
{
    use HtmxTriggerTrait;

    private array $allowedKeys = [
        '',
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
