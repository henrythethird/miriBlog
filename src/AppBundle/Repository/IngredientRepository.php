<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class IngredientRepository extends EntityRepository  {
	public function findFirstLetters() {
		return $this->createQueryBuilder('i')
			->select('SUBSTRING(i.name, 1, 1) AS letter')
			->groupBy('letter')
			->getQuery()
			->getScalarResult()
		;
	}

	public function findByFirstLetter($firstLetter) {
		return $this->createQueryBuilder('i')
			->where('SUBSTRING(i.name, 1, 1) = :LETTER')
			->setParameter('LETTER', $firstLetter)
			->orderBy('i.name', 'ASC')
			->getQuery()
			->getResult()
		;
	}
}