<?php

namespace App\Form;

use App\Entity\AmmoType;
use App\Entity\Constant\FireModes;
use App\Entity\Tag;
use App\Entity\Weapon;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class WeaponType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class, [
                'attr' => ['rows' => 5],
            ])
            ->add('type', EntityType::class, [
                'class' => Tag::class,
                'query_builder' => function (TagRepository $tagRepository) {
                    return $tagRepository->createQueryBuilder('t')
                        ->andWhere('t.type = :type')
                        ->orderBy('t.name', 'ASC')
                        ->setParameter('type', 'weapons')  ;
                }
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k'
                    ])
                ]
            ])
            ->add('bodyDamage')
            ->add('headDamage')
            ->add('rateOfFire')
            ->add('fireMode', ChoiceType::class, ['choices' => FireModes::formValues()])
            ->add('ammoType', EntityType::class, ['class' => AmmoType::class])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Weapon::class,
        ]);
    }
}
