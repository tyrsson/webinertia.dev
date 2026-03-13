<?php

declare(strict_types=1);

namespace Htmx;

enum Swap: string
{
    case InnerHTML   = 'innerHTML';
    case OuterHTML   = 'outerHTML';
    case BeforeBegin = 'beforebegin';
    case AfterBegin  = 'afterbegin';
    case BeforeEnd   = 'beforeend';
    case AfterEnd    = 'afterend';
    case Delete      = 'delete';
    case None        = 'none';
}
