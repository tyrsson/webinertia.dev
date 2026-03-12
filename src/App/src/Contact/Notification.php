<?php

declare(strict_types=1);

namespace App\Contact;

use Axleus\Message;

final class Notification extends Message\AbstractMessage implements 
    Message\MessageIconCapableInterface,
    Message\MessageLevelCapableInterface
{
    use Message\MessageIconCapableTrait;
    use Message\MessageLevelCapableTrait;
}
