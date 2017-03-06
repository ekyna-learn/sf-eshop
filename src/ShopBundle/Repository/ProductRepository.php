<?php

namespace ShopBundle\Repository;

use ShopBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 */
class ProductRepository extends EntityRepository
{
    /**
     * Finds one product by category and slug.
     *
     * @param Category $category
     * @param string   $slug
     *
     * @return \ShopBundle\Entity\Product|null
     */
    public function findOneByCategoryAndSlug(Category $category, $slug)
    {
        $qb = $this->createQueryBuilder('p');

        return $qb
            ->where($qb->expr()->eq('p.category', ':category'))
            ->andWhere($qb->expr()->eq('p.slug', ':slug'))
            ->getQuery()
            ->setParameters([
                'category' => $category,
                'slug'     => $slug,
            ])
            ->getOneOrNullResult();
    }

    /**
     * Finds products by category.
     *
     * @param Category $category
     *
     * @return \ShopBundle\Entity\Product[]
     */
    public function findByCategory(Category $category)
    {
        $qb = $this->createQueryBuilder('p');

        return $qb
            ->where($qb->expr()->eq('p.category', ':category'))
            ->getQuery()
            ->setParameter('category', $category)
            ->getResult();
    }
}
