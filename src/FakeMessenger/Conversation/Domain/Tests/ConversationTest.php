<?php

namespace FakeMessenger\Conversation\Domain\Tests;

use FakeMessenger\Conversation\Domain\Entity\Conversation;
use FakeMessenger\Conversation\Domain\Entity\ConversationId;
use FakeMessenger\Conversation\Domain\Entity\Message;
use FakeMessenger\Conversation\Domain\Entity\User;
use FakeMessenger\Conversation\Domain\Entity\Username;
use PHPUnit\Framework\TestCase;

class ConversationTest extends TestCase
{
    public function testCreateConversation()
    {
        $conversation = new Conversation(
            ConversationId::generate(),
            new User(new Username('Some name'))
        );

        $this->assertInstanceOf(Conversation::class, $conversation);

        $messages = [
            new Message($conversation, (new \DateTimeImmutable())->modify('-20 second'), 'yo'),
            new Message($conversation, (new \DateTimeImmutable())->modify('-15 second'), 'yo, what\'s up?'),
            new Message($conversation, (new \DateTimeImmutable())->modify('-10 second'), 'Nothing new'),
        ];

        $conversation
            ->addMessage($messages[0])
            ->addMessage($messages[1])
            ->addMessage($messages[2]);

        $this->assertEquals(3, $conversation->getMessages()->count());
        $this->assertInstanceOf(Message::class, $conversation->getMessages()->first());
        $this->assertEquals('yo', $conversation->getMessages()->first()->getContent());
    }
}