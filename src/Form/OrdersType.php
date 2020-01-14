<?php

namespace App\Form;

use App\Entity\Orders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount')
            ->add('userid')
            ->add('name')
            ->add('lastname')
            ->add('address', TextareaType::class, [
                'attr' => [
                    'rows' => '10',
                ],
            ])
            ->add('phone')
            ->add('city')
            ->add('shipinfo', TextareaType::class, [
                'attr' => [
                    'rows' => '10',
                ],
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'New' => 'New',
                    'Accepted' => 'Accepted',
                    'In Shipping' => 'In Shipping',
                    'Completed' => 'Completed',
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
