<?php

namespace ShopBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Finds one enabled category by slug.
     *
     * @param string $slug
     *
     * @return \ShopBundle\Entity\Category|null
     */
    public function findEnabledBySlug($slug)
    {
        $qb = $this->createQueryBuilder('c');

        return $qb
            ->andWhere($qb->expr()->eq('c.slug', ':slug'))
            ->andWhere($qb->expr()->eq('c.enabled', ':enabled'))
            ->getQuery()
            ->setParameters([
                'slug'    => $slug,
                'enabled' => true,
            ])
            ->getOneOrNullResult();
    }
}
