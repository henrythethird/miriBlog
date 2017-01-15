<?php

namespace AppBundle\Repository;

use AppBundle\Aggregate\ArchiveAggregate;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PostRepository extends EntityRepository
{
    const NUM_FIRSTPAGE_RESULTS = 3;
	const ARCHIVE_LIMIT = 4;

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
	 * @return Post[]
	 */
	public function findArchiveResults() {
		return $this->findArchiveReultsQb()
			->getQuery()
			->getResult();
    }

	/**
	 * @param $offset
	 *
	 * @return ArchiveAggregate
	 */
	public function findArchiveResultsPaginator($offset) {
		$queryBuilder = $this->findArchiveReultsQb($offset);

		$paginator = new Paginator($queryBuilder);

		return new ArchiveAggregate(
			ceil($paginator->count() / self::ARCHIVE_LIMIT),
			$paginator->getQuery()->getResult()
		);
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

	/**
	 * @param $offset
	 *
	 * @return \Doctrine\ORM\QueryBuilder
	 */
	private function findArchiveReultsQb($offset = 0) {
		$queryBuilder = $this->createSortedQueryBuilder()
			->setMaxResults(self::ARCHIVE_LIMIT)
			->setFirstResult(self::ARCHIVE_LIMIT * $offset);

		return $queryBuilder;
}
}