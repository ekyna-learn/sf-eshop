<?php

namespace ShopBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'label' => 'Titre',
            ])
            ->add('category', 'entity', [
                'class'         => 'ShopBundle\Entity\Category',
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('c');

                    return $qb
                        ->andWhere($qb->expr()->eq('c.enabled', ':enabled'))
                        ->orderBy('c.title', 'ASC')
                        ->setParameter('enabled', true);
                },
            ])
            ->add('description', 'textarea', [
                'attr' => [
                    'rows' => 8,
                ],
            ])
            ->add('price', 'number', [
                'label'     => 'Prix',
                'precision' => 2,
            ])
            ->add('stock', 'number', [
                'precision' => 0,
            ])
            ->add('releasedAt', 'date', [
                'label'  => 'Date de sortie',
                'widget' => 'single_text',
            ])
            ->add('features', 'entity', [
                'class'    => 'ShopBundle\Entity\Feature',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('seo', new SeoType())
            ->add('images', 'collection', [
                'type'         => new ImageType(),
                'allow_add'    => true,
                'allow_delete' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'ShopBundle\Entity\Product',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'shop_product';
    }
}
