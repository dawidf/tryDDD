<?php

namespace FakeMessenger\Conversation\Domain\Exception;

use FakeMessenger\Common\Domain\Exception\InvalidArgumentException;

class InvalidNameException extends InvalidArgumentException
{
    public static function emptyName()
    {
        return new self('Name cannot be empty');
    }
}