<?php

namespace FakeMessengerBundle\Controller;

use FakeMessenger\Common\Domain\Exception\NotFountException;
use FakeMessenger\Conversation\Application\Command\CreateConversationCommand;
use FakeMessenger\Conversation\Application\Command\CreateMessageCommand;
use FakeMessenger\Conversation\Domain\Entity\ConversationId;
use FakeMessenger\Conversation\Domain\Entity\Username;
use FakeMessenger\Conversation\Domain\Exception\ConversationNotFoundException;
use FakeMessenger\Conversation\Infrastructure\Symfony\Form\Type\ConversationType;
use FakeMessenger\Conversation\Infrastructure\Symfony\Form\Type\MessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConversationController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(ConversationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $conversationId = ConversationId::generate();

            $this->get('tactician.commandbus')->handle(
                new CreateConversationCommand(
                    $conversationId,
                    $form->get('from')->getData())
            );

            return $this->redirectToRoute('show_conversation', [
                'conversationId' => $conversationId,
            ]);
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/conversation/{conversationId}", name="show_conversation")
     * @Template()
     */
    public function showAction(string $conversationId, Request $request)
    {
        try {
            $conversation = $this->get('fake_messenger.conversation.manager')
                ->findById($conversationId);

        } catch (ConversationNotFoundException $exception) {
            throw $this->createNotFoundException($exception->getMessage());
        }

        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('tactician.commandbus')->handle(
                new CreateMessageCommand(
                    $conversation,
                    new \DateTimeImmutable(),
                    $form->get('content')->getData()
                )
            );
        }

        return [
            'conversation' => $conversation,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/message/create")
     */
    public function createMessageAction(Request $request)
    {
        $conversationId = $request->get('conversationId');
        $content = $request->get('content');

        try {
            $conversation = $this->get('fake_messenger.conversation.manager')
                ->findById($conversationId);
        } catch (ConversationNotFoundException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }

        $this->get('tactician.commandbus')->handle(
            new CreateMessageCommand(
                $conversation,
                new \DateTimeImmutable(),
                $content
            )
        );

        return new JsonResponse(['message' => 'ok']);
    }
}
