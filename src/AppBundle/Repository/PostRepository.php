<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    const NUM_FIRSTPAGE_RESULTS = 3;
	const ARCHIVE_LIMIT = 24;

	/**
	 * @return Post[]
	 */
    public function findAllFirstPageResults()
    {
        return $this->createSortedQueryBuilder()
            ->setMaxResults(self::NUM_FIRSTPAGE_RESULTS)
	        ->getQuery()
	        ->getResult();
    }

	/**
	 * @param int $offset
	 * @return Post[]
	 */
	public function findArchiveResults($offset) {
		return $this->createSortedQueryBuilder()
			->setMaxResults(self::ARCHIVE_LIMIT)
			->getQuery()
			->getResult();
    }

	/**
	 * @return \Doctrine\ORM\QueryBuilder
	 */
	public function createSortedQueryBuilder() {
		return $this->createQueryBuilder('p')
			->addOrderBy('p.datePublished', 'DESC')
			->where('p.datePublished <= :NOW')
			->setParameters(['NOW' => new \DateTime()]);
	}
}