<?php


namespace App\Form;


use App\Entity\Tag;
use App\Repository\TagRepository;
use App\Search\Search;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newsTags', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Tag::class,
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (TagRepository $tagRepository) {
                    return $tagRepository->createQueryBuilder('t')
                                         ->andWhere('t.type = :type')
                                         ->setParameter('type', 'news')
                                         ->orderBy('t.name', 'ASC');
                }
            ])
            ->add('weaponsTags', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Tag::class,
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (TagRepository $tagRepository) {
                    return $tagRepository->createQueryBuilder('t')
                                         ->andWhere('t.type = :type')
                                         ->setParameter('type', 'weapons')
                                         ->orderBy('t.name', 'ASC');
                }
            ])
            ->add('heroesTags', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Tag::class,
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (TagRepository $tagRepository) {
                    return $tagRepository->createQueryBuilder('t')
                                         ->andWhere('t.type = :type')
                                         ->setParameter('type', 'heroes')
                                         ->orderBy('t.name', 'ASC');
                }
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class
        ]);
    }
}