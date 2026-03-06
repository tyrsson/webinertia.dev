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

use App\Htmx\ResponseHeaders as HtmxHeader;

use function json_encode;

trait HtmxHandlerTrait
{
    private string $domTarget = '#app-main';

    private function hxLocation(array $params): array
    {
        $data = ['target' => $this->domTarget];
        $data = $params + $data;

        return [HtmxHeader::HX_Location->value => json_encode($data)];
    }
}
