<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Doctrine\ORM\Mapping\Entity
 * @Doctrine\ORM\Mapping\Table(name="ingredients")
 */
class Ingredient {
    /**
     * @Doctrine\ORM\Mapping\Id
     * @Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
     * @Doctrine\ORM\Mapping\Column(type="integer")
     */
    private $id;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string")
     */
    private $name;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\PostIngredient", mappedBy="ingredient")
	 */
	private $postIngredients;

	public function __construct() {
		$this->postIngredients = new ArrayCollection();
	}
	
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return PostIngredient[]|ArrayCollection
	 */
	public function getPostIngredients() {
		return $this->postIngredients;
	}

	/**
	 * @param PostIngredient[]|ArrayCollection $postIngredients
	 */
	public function setPostIngredients($postIngredients) {
		$this->postIngredients = $postIngredients;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
}