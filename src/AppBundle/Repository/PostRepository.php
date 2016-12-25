<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    const NUM_FIRSTPAGE_RESULTS = 3;

    public function findAllFirstPageResults()
    {
        $this->createQueryBuilder('p')
            ->addOrderBy('p.datePublished')
            ->where('p.datePublished >= :NOW')
            ->setParameters([
                'NOW' => new \DateTime()
            ])
            ->setMaxResults(self::NUM_FIRSTPAGE_RESULTS)
        ;
    }
}