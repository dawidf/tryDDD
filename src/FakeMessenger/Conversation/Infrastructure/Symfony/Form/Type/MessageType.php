<?php

namespace FakeMessenger\Conversation\Infrastructure\Symfony\Form\Type;

use FakeMessenger\Conversation\Application\Command\CreateMessageCommand;
use FakeMessenger\Conversation\Domain\Entity\Conversation;
use FakeMessenger\Conversation\Domain\Entity\Message;
use FakeMessenger\Conversation\Domain\Repository\ConversationRepositoryInterface;
use FakeMessenger\Conversation\Infrastructure\Doctrine\ORM\Repository\ConversationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
//            'data_class' => CreateMessageCommand::class,
        ]);
    }
}