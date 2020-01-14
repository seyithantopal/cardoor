<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Security;

class ImageType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $this->security->getUser();
        $user_id = $user->getId();
        $roles = $user->getRoles();


        $builder
            ->add('title')
            ->add('image', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ])
        ;
        if($roles[0] == 'ROLE_ADMIN') {
            $builder->add('car', EntityType::class, [
                'class' => Car::class,
                'choice_label' => 'title',
                'required' => false,
            ])
            ;
        } else {
            $builder->add('car', EntityType::class, [
                'class' => Car::class,
                'query_builder' => function(EntityRepository $er) use($user_id) {
                    //$carId = $options['data']->getTitle();
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.userid = :val')
                        ->setParameter('val', $user_id);
                },
                'choice_label' => 'title',
                'required' => false,
            ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
