<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * @method AbstractPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractPost[] findAll()
 * @method AbstractPost[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractPostRepository extends EntityRepository
{
    /**
     * @return AbstractPost[]
     */
    public function findPublished(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.published = :published')
            ->setParameter('published', true)
            ->getQuery()
            ->getResult()
        ;
    }
}
