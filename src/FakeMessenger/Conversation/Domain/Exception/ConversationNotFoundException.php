<?php

namespace FakeMessenger\Conversation\Domain\Exception;

use FakeMessenger\Common\Domain\Exception\NotFountException;

class ConversationNotFoundException extends NotFountException
{
    public static function conversationNotFound()
    {
        return new self('Conversation not found');
    }
}