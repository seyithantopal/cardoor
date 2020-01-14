<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Full Name',
                ],
                'required' => true,
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                ],
                'required' => true,
            ])
            ->add('subject', TextType::class, [
                'attr' => [
                    'placeholder' => 'Subject',
                ],
                'required' => true,
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Message',
                    'rows' => '10',
                ],
                'required' => true,
            ])
            ->add('status', CheckboxType::class, [
                'attr' => ['class' => 'js-single'],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
