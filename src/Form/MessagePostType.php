<?php

namespace App\Form;

use App\Entity\TicketPost;
use App\Entity\MessagePost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessagePostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("MessageField")
            ->add('ticket', EntityType::class, [
                "class" => TicketPost::class,
                "choice_label" => "title",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MessagePost::class,
        ]);
    }
}
