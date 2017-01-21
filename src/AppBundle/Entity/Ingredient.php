<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="AppBundle\Repository\IngredientRepository")
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
     * @Doctrine\ORM\Mapping\Column(type="string", unique=true)
     */
    private $name;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\RecipeIngredient", mappedBy="ingredient")
	 */
	private $recipeIngredients;

	/**
	 * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
	 */
	private $picture;

	/**
	 * @ORM\Column(type="string", length=128, unique=true)
	 * @Gedmo\Slug(fields={"name"})
	 */
	private $slug;

	public function __construct() {
		$this->recipeIngredients = new ArrayCollection();
	}
	
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * @param mixed $slug
	 */
	public function setSlug($slug) {
		$this->slug = $slug;
	}

	/**
	 * @return RecipeIngredient[]|ArrayCollection
	 */
	public function getRecipeIngredients() {
		return $this->recipeIngredients;
	}

	/**
	 * @param RecipeIngredient[]|ArrayCollection $recipeIngredients
	 */
	public function setRecipeIngredients($recipeIngredients) {
		$this->recipeIngredients = $recipeIngredients;
	}

	/**
	 * @return MediaInterface
	 */
	public function getPicture() {
		return $this->picture;
	}

	/**
	 * @param MediaInterface $picture
	 */
	public function setPicture($picture) {
		$this->picture = $picture;
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

	public function __toString() {
		return $this->getName();
	}
}