<?php

namespace FakeMessenger\Conversation\Infrastructure\Doctrine\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use FakeMessenger\Conversation\Domain\Conversations;
use FakeMessenger\Conversation\Domain\Entity\Conversation;
use FakeMessenger\Conversation\Domain\Exception\ConversationNotFoundException;

final class ConversationManager implements Conversations
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function add(Conversation $conversation): void
    {
        $this->em->persist($conversation);
        $this->em->flush();
    }

    public function remove(Conversation $conversation): void
    {
        $this->em->remove($conversation);
        $this->em->flush();
    }

    public function findAll(int $limit = 10, int $offset = 0): array
    {
        return $this->em->getRepository(Conversation::class)
            ->findAll($limit, $offset);
    }

    /**
     * @throws ConversationNotFoundException
     */
    public function findById(string $conversationId): Conversation
    {
        $conversation = $this->em->getRepository(Conversation::class)
            ->findById($conversationId);

        if ($conversation === null) {
            throw ConversationNotFoundException::conversationNotFound();
        }

        return $conversation;
    }
}