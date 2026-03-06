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
 * @see https://htmx.org/reference/#response_headers
 */
enum ResponseHeaders: string
{
    use EnumTrait;

    case HX_Location             = 'HX-Location';
    case HX_Push_Url             = 'HX-Push-Url';
    case HX_Redirect             = 'HX-Redirect';
    case HX_Refresh              = 'HX-Refresh';
    case HX_Replace_Url          = 'HX-Replace-Url';
    case HX_Reswap               = 'HX-Reswap';
    case HX_Retarget             = 'HX-Retarget';
    case HX_Reselect             = 'HX-Reselect';
    case HX_Trigger              = 'HX-Trigger';
    case HX_Trigger_After_Settle = 'HX-Trigger-After-Settle';
    case HX_Trigger_After_Swap   = 'HX-Trigger-After-Swap';
}
