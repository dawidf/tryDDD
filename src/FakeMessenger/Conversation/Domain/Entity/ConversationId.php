<?php

namespace FakeMessenger\Conversation\Domain\Entity;

use Ramsey\Uuid\Uuid;
use FakeMessenger\Common\Domain\UUID as BaseUUID;

class ConversationId extends BaseUUID
{
    public static function generate(): ConversationId
    {
        return new self((string)Uuid::uuid4());
    }
}