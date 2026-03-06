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

use App\EnumTrait;

/**
 * @see https://htmx.org/reference/#request_headers
 */
enum RequestHeaders: string
{
    use EnumTrait;

    case HX_Boosted                 = 'hx-boosted';
    case HX_Current_Url             = 'hx-current-url';
    case HX_History_Restore_Request = 'hx-history-restore-request';
    case HX_Prompt                  = 'hx-prompt';
    case HX_Request                 = 'hx-request';
    case HX_Target                  = 'hx-target';
    case HX_Trigger_Name            = 'hx-trigger-name';
    case HX_Trigger                 = 'hx-trigger';
}
