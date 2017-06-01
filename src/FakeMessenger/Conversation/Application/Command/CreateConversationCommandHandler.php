<?php

namespace FakeMessenger\Conversation\Application\Command;

use FakeMessenger\Conversation\Domain\Conversations;
use FakeMessenger\Conversation\Domain\Entity\Conversation;
use FakeMessenger\Conversation\Domain\Entity\ConversationId;
use FakeMessenger\Conversation\Domain\Entity\User;
use FakeMessenger\Conversation\Domain\Entity\Username;

class CreateConversationCommandHandler
{
    private $conversations;

    public function __construct(Conversations $conversations)
    {
        $this->conversations = $conversations;
    }

    public function handle(CreateConversationCommand $command)
    {
        $conversation = new Conversation(
            new ConversationId($command->getId()),
            new User(new Username($command->getFrom()
            )));

        $this->conversations->add(
            $conversation
        );

        return $conversation;
    }
}