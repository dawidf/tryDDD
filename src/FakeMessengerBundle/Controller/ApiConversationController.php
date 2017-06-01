<?php

namespace FakeMessengerBundle\Controller;

use FakeMessenger\Conversation\Application\Command\CreateMessageCommand;
use FakeMessenger\Conversation\Domain\Entity\Message;
use FakeMessenger\Conversation\Domain\Exception\MessageNotFoundException;
use FakeMessenger\Conversation\Infrastructure\Symfony\Form\Type\MessageType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\Exception\ValidationFailedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Rest\Route("/api/")
 */
class ApiConversationController extends FOSRestController
{
    /**
     * @Rest\Post("messages", name="create_message")
     * @Rest\RequestParam(name="content", requirements="\d+", nullable=false)
     * @Rest\RequestParam(name="conversation", requirements="\d+", nullable=false)
     */
    public function postMessageAction(Request $request)
    {
        $messageCommand = new CreateMessageCommand(
            $request->request->get('conversation'),
            new \DateTimeImmutable(),
            $request->request->get('content')
        );

        $form = $this->createForm(MessageType::class);
        $this->removeExtraFields($request, $form);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $message = $this->get('tactician.commandbus')->handle(
                $messageCommand
            );

            $view = $this->view($message, Response::HTTP_OK);
        } else {

            $view = $this->view($form, Response::HTTP_BAD_REQUEST);
        }

//        if ($errors->count()) {
//            $view = $this->view($errors, Response::HTTP_BAD_REQUEST);
//        } else {
//            $view = $this->view($message, Response::HTTP_OK);
//        }

        return $this->handleView($view);
    }

    /**
     * Get rid on any fields that don't appear in the form
     *
     * @param Request $request
     * @param Form $form
     */
    protected function removeExtraFields(Request $request, Form $form)
    {
        $data = $request->request->all();
        $children = $form->all();
        $data = array_intersect_key($data, $children);
        $request->request->replace($data);
    }

    /**
     * @Rest\Get("messages", name="get_messages")
     */
    public function getMessagesAction()
    {
        $conversations = $this->get('fake_messenger.conversation.manager')->findAll();

        return $conversations;
    }

    /**
     * @Rest\Get("messages/{messageId}", name="get_message")
     */
    public function getMessageAction(int $messageId)
    {
        try {
            $message = $this->get('fake_messenger.message.manager')->findById($messageId);
        } catch (MessageNotFoundException $exception) {
            $view = $this->view($exception->getMessage(), Response::HTTP_NOT_FOUND);

            return $this->handleView($view);
        }

        return $message;
    }
}
