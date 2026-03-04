<?php

declare(strict_types=1);

namespace App\Htmx;

use App\EnumTrait;
/**
 * @link https://htmx.org/reference/#request_headers
 */
Enum RequestHeaders: string
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
