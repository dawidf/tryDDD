<?php

namespace FakeMessenger\Conversation\Domain;

use FakeMessenger\Conversation\Domain\Entity\Message;

interface Messages
{
    public function add(Message $conversation): void;

    public function remove(Message $conversation): void;

    /**
     * @return Message[]
     */
    public function findByConversationId(int $conversationId): array;

    public function findById(int $messageId): Message;
}