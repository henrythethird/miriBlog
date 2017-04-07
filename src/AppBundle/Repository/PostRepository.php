<?php

namespace AppBundle\Repository;

use AppBundle\Aggregate\PostAggregate;
use AppBundle\Entity\Category;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
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
    	return $this->findAllFirstPageResultsQb()
		    ->getQuery()
		    ->getResult();
    }

	public function findAllFirstPageResultsPaginator($offset)
	{
		return $this->getResultsPaginator(
			$this->findAllFirstPageResultsQb($offset),
			self::NUM_FIRSTPAGE_RESULTS
		);
    }

    private function findAllFirstPageResultsQb($offset = 0)
    {
	    return $this->queryBuilderOffset(
		    $this->createSortedQueryBuilder(),
		    $offset,
		    self::NUM_FIRSTPAGE_RESULTS
	    );
    }

	public function findRecentPosts() {
		return $this->createSortedQueryBuilder()
			->setMaxResults(self::NUM_RECENT_RESULTS)
			->setFirstResult(self::NUM_FIRSTPAGE_RESULTS)
			->getQuery()
			->getResult();
    }

    /**
     * @return Post[]
     */
    public function findSubscribePosts()
    {
        return $this->createQueryBuilder('p')
            ->where('p.dateMailPublished IS NULL')
            ->andWhere('p.datePublished <= :DATE')
            ->setParameter('DATE', new \DateTime("+48 hours"))
            ->orderBy('p.datePublished')
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
            $queryBuilder->leftJoin('p.categories', 'category');
			$queryBuilder->andWhere('category = :CATEGORY');
			$queryBuilder->setParameter('CATEGORY', $filterCategory);
		}
		return $queryBuilder
			->getQuery()
			->getResult();
    }

	/**
	 * @param $offset
	 * @return PostAggregate
	 */
	public function findArchiveResultsPaginator($offset) {
		return $this->getResultsPaginator(
			$this->findArchiveReultsQb($offset),
			self::ARCHIVE_LIMIT
		);
    }

    private function getResultsPaginator(QueryBuilder $queryBuilder, $numItems) {
		$paginator = new Paginator($queryBuilder);

	    return new PostAggregate(
		    ceil($paginator->count() / $numItems),
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
		return $this->queryBuilderOffset(
			$this->createSortedQueryBuilder(),
			$offset,
			self::ARCHIVE_LIMIT
		);
	}

	private function queryBuilderOffset(QueryBuilder $queryBuilder, $offset, $increment) {
		return $queryBuilder
			->setMaxResults($increment)
			->setFirstResult($increment * $offset);
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