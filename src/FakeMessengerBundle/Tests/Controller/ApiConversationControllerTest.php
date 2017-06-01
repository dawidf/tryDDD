<?php

namespace FakeMessengerBundle\Tests\Controller;

use FakeMessenger\Conversation\Domain\Entity\Conversation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiConversationControllerTest extends WebTestCase
{
    public function testAddMessage()
    {
        $client = $this->createClient();

        $conversation = Conversation::create('user test');

        $client->getContainer()->get('fake_messenger.conversation.manager')
            ->add($conversation);

        $formData = [
            'conversation' => $conversation,
            'content' => 'test message',
        ];

        $client->request(
            'POST',
            '/api/messages',
            $formData
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

    }
}
