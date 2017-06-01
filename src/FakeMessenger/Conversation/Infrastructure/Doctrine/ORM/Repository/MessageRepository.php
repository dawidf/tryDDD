<?php

namespace FakeMessenger\Conversation\Infrastructure\Doctrine\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use FakeMessenger\Conversation\Domain\Entity\Message;
use FakeMessenger\Conversation\Domain\Repository\MessageRepositoryInterface;

class MessageRepository extends EntityRepository implements MessageRepositoryInterface
{
    public function findById(int $messageId): ?Message
    {
        $qb = $this->createQueryBuilder('message');
        $qb
            ->where($qb->expr()->eq('message.id', ':messageId'))
            ->setParameter('messageId', $messageId);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return Message[]
     */
    public function findByConversationId(int $conversationId): array
    {
        $qb = $this->createQueryBuilder('message');
        $qb
            ->where($qb->expr()->eq('message.conversation', ':conversationId'))
            ->setParameter('conversationId', $conversationId);

        return $qb->getQuery()->getResult();
    }
}