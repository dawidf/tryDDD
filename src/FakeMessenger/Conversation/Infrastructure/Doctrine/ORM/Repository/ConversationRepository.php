<?php

namespace FakeMessenger\Conversation\Infrastructure\Doctrine\ORM\Repository;

use Doctrine\ORM\EntityRepository;
use FakeMessenger\Conversation\Domain\Entity\Conversation;
use FakeMessenger\Conversation\Domain\Repository\ConversationRepositoryInterface;

class ConversationRepository extends EntityRepository implements ConversationRepositoryInterface
{
    public function findById(string $conversationId): ?Conversation
    {
        $qb = $this->createQueryBuilder('conversation');

        $qb
            ->select('conversation', 'messages')
            ->leftJoin('conversation.messages', 'messages')
            ->where($qb->expr()->eq('conversation.id.id', ':conversationId'))
            ->setParameter('conversationId', $conversationId);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return Conversation[]
     */
    public function findAll(int $limit = 10, int $offset = 0): array
    {
        $qb = $this->createQueryBuilder('conversation');

        $qb
            ->select('conversation', 'messages')
            ->innerJoin('conversation.messages', 'messages');

        return $qb->getQuery()->getResult();
    }
}