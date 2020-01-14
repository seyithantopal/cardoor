<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Repository\CarRepository;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $options['data'];
        $carId = $options['data']->getId();


        $builder
            ->add('category')
            ->add('title')
            ->add('description')
            ->add('keywords', TextType::class, [
                'attr' => ['id' => 'tags'],
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('star', ChoiceType::class, [
                'attr' => ['class' => 'rating-star'],
                'choices' => [
                        '1' => 1,
                        '2' => 2,
                        '3' => 3,
                        '4' => 4,
                        '5' => 5,
                    ],
            ])
            ->add('price', MoneyType::class, [
                'currency' => 'USD',
                'required' => false,
            ])

            ->add('fuel', ChoiceType::class, [
                'attr' => ['class' => 'select2'],
                'choices' => [
                    'Electric' => 'Electric',
                    'Diesel' => 'Diesel',
                    'Hybrid' => 'Hybrid',
                    'Natural Gas' => 'Natural Gas',
                ],
                //'class' => Car::class,
                /*'query_builder' => function(EntityRepository $er) use($carId) {
                    //$carId = $options['data']->getTitle();
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.id', 'DESC')
                        ->andWhere('c.id = :val')
                        ->setParameter('val', $carId);
                },
                'choice_label' => 'fuel',
                'required' => false,
                'choice_value' => 'fuel',*/


                /*---------------------------*/

                /*'choice_label' => function(Car $user) use($carId) {
                    $str = array();
                    if($user->getId() == $carId) {
                        $str = sprintf('%s', $user->getFuel());
                    } else {
                        $str = sprintf('%s', $user->getFuel());

                    }
                    return $str;
                },
                'choice_label' => 'fuel',
                'choice_value' => 'id',
                'placeholder' => 'Choose an author',*/
                /*'choice_label' => function(Car $user) use($carId) {
                    $i = 0;
                    $ar = [
                            '0' => 0,
                            '1' => 1,
                        ];
                    $str = sprintf('%s', $user->getFuel());
                    $str =sprintf('%s', $ar[$i++]);
                    return $str;
                },*/

            ])
            ->add('doors')
            ->add('gearbox', ChoiceType::class, [
                'choices' => [
                    'Automatic' => 'Automatic',
                    'Manuel' => 'Manuel',
                ],
            ])
            ->add('status', CheckboxType::class, [
                'attr' => ['class' => 'js-switch'],
                'required' => false,
            ])
            ->add('abs', CheckboxType::class, [
                'attr' => ['class' => 'js-switch'],
                'required' => false,
            ])
            ->add('airbag', CheckboxType::class, [
                'attr' => ['class' => 'js-single'],
                'required' => false,
            ])
            ->add('bluetooth', CheckboxType::class, [
                'attr' => ['class' => 'js-switch'],
                'required' => false,
            ])
            ->add('carkit', CheckboxType::class, [
                'attr' => ['class' => 'js-switch'],
                'required' => false,
            ])
            ->add('gps', CheckboxType::class, [
                'attr' => ['class' => 'js-switch'],
                'required' => false,
            ])
            ->add('remote_start', CheckboxType::class, [
                'attr' => ['class' => 'js-switch'],
                'required' => false,
            ])
            ->add('parking_cameras', CheckboxType::class, [
                'attr' => ['class' => 'js-switch'],
                'required' => false,
            ])
            ->add('music', CheckboxType::class, [
                'attr' => ['class' => 'js-switch'],
                'required' => false,
            ])
            ->add('detail', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
            'csrf_protection' => false,
        ]);
    }
}
