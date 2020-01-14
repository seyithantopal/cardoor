<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Car1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('keywords')
            ->add('image')
            ->add('star')
            ->add('price')
            ->add('fuel')
            ->add('doors')
            ->add('gearbox')
            ->add('abs')
            ->add('airbag')
            ->add('bluetooth')
            ->add('carkit')
            ->add('gps')
            ->add('remote_start')
            ->add('parking_cameras')
            ->add('music')
            ->add('status')
            ->add('created_at')
            ->add('updated_at')
            ->add('detail')
            ->add('userid')
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
