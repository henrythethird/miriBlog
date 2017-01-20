<?php

namespace AppBundle\Repository;

use AppBundle\Aggregate\ArchiveAggregate;
use AppBundle\Entity\Category;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PostRepository extends EntityRepository
{
    const NUM_FIRSTPAGE_RESULTS = 3;
	const NUM_RECENT_RESULTS = 3;
	const ARCHIVE_LIMIT = 1000;

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

	public function findRecentPosts() {
		return $this->createSortedQueryBuilder()
			->setMaxResults(self::NUM_RECENT_RESULTS)
			->setFirstResult(self::NUM_FIRSTPAGE_RESULTS)
			->getQuery()
			->getResult();
    }

	/**
	 * @param Category|null $filterCategory
	 *
	 * @return Post[]
	 */
	public function findArchiveResults(Category $filterCategory = null) {
		$queryBuilder = $this->findArchiveReultsQb();

		if ($filterCategory) {
			$queryBuilder->andWhere('p.category = :CATEGORY');
			$queryBuilder->setParameter('CATEGORY', $filterCategory);
		}
		return $queryBuilder
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

	/**
	 * @param Ingredient $ingredient
	 *
	 * @return Post[]
	 */
	public function findByIngredient(Ingredient $ingredient = null) {
		return $this->createSortedQueryBuilder()
			->leftJoin('p.recipes', 'recipes')
			->leftJoin('recipes.recipeIngredients', 'recipeIngredients')
			->andWhere('recipeIngredients.ingredient = :INGREDIENT')
			->setParameter('INGREDIENT', $ingredient)
			->getQuery()
			->getResult();
	}
}