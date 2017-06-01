<?php

namespace FakeMessenger\Conversation\Infrastructure\Doctrine\Manager;

use Doctrine\ORM\EntityManager;
use FakeMessenger\Conversation\Domain\Entity\Message;
use FakeMessenger\Conversation\Domain\Exception\MessageNotFoundException;
use FakeMessenger\Conversation\Domain\Messages;

final class MessageManager implements Messages
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function add(Message $conversation): void
    {
        $this->em->persist($conversation);
        $this->em->flush();
    }

    public function remove(Message $conversation): void
    {
        $this->em->remove($conversation);
        $this->em->flush();
    }

    /**
     * @return Message[]
     */
    public function findByConversationId(int $conversationId): array
    {
        return $this->em->getRepository(Message::class)
            ->findByConversationId($conversationId);
    }

    public function findById(int $messageId): Message
    {
        $message = $this->em->getRepository(Message::class)
            ->findById($messageId);

        if ($message === null) {
            throw MessageNotFoundException::messageNotFound();
        }

        return $message;
    }
}