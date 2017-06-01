<?php

namespace FakeMessenger\Conversation\Domain;

use FakeMessenger\Conversation\Domain\Entity\Conversation;
use FakeMessenger\Conversation\Domain\Exception\ConversationNotFoundException;

interface Conversations
{
    public function add(Conversation $conversation): void;

    public function remove(Conversation $conversation): void;

    public function findAll(int $limit = 10, int $offset = 0): array;

    /**
     * @throws ConversationNotFoundException
     */
    public function findById(string $conversationId): Conversation;
}