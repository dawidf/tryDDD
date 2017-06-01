<?php

namespace FakeMessenger\Conversation\Domain\Repository;

use FakeMessenger\Conversation\Domain\Entity\Message;

interface MessageRepositoryInterface
{
    public function findById(int $messageId): ?Message;

    public function findByConversationId(int $conversationId): array;
}