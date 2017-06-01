<?php

namespace FakeMessenger\Conversation\Domain\Repository;

use FakeMessenger\Conversation\Domain\Entity\Conversation;

interface ConversationRepositoryInterface
{
    public function findAll(int $limit = 10, int $offset = 0): array;

    public function findById(string $conversationId): ?Conversation;
}