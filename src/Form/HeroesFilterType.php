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

class HeroesFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tags', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Tag::class,
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (TagRepository $tagRepository) use ($options) {
                    return $tagRepository->createQueryBuilder('t')
                                         ->andWhere('t.type = :type')
                                         ->orderBy('t.name', 'ASC')
                                         ->setParameter('type', 'heroes');
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