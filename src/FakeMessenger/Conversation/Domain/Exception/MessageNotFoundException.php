<?php

namespace FakeMessenger\Conversation\Domain\Exception;

use FakeMessenger\Common\Domain\Exception\NotFountException;

class MessageNotFoundException extends NotFountException
{
    public static function messageNotFound()
    {
        return new self('Message not found');
    }
}