<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe")
 */
class Recipe {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $title;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post", inversedBy="recipes")
	 */
	private $post;

	/**
	 * @ORM\Column(type="string")
	 */
	private $feedsNPeople;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\RecipeIngredient", mappedBy="recipe", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(referencedColumnName="ingredient_id")
	 */
	private $recipeIngredients;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Step", mappedBy="recipe", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(referencedColumnName="post_id")
	 */
	private $steps;

	public function __construct() {
		$this->recipeIngredients = new ArrayCollection();
		$this->steps = new ArrayCollection();
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getPost() {
		return $this->post;
	}

	/**
	 * @param mixed $post
	 */
	public function setPost($post) {
		$this->post = $post;
	}

	/**
	 * @return Step[]|ArrayCollection
	 */
	public function getSteps() {
		return $this->steps;
	}

	/**
	 * @return string
	 */
	public function getFeedsNPeople() {
		return $this->feedsNPeople;
	}

	/**
	 * @param string $feedsNPeople
	 */
	public function setFeedsNPeople($feedsNPeople) {
		$this->feedsNPeople = $feedsNPeople;
	}

	/**
	 * @param Step[]|ArrayCollection $steps
	 */
	public function setSteps($steps) {
		$this->steps = $steps;
	}

	public function addStep(Step $step) {
		$step->setRecipe($this);
		$this->steps->add($step);
	}

	public function removeStep(Step $step) {
		$this->steps->removeElement($step);
	}

	/**
	 * @return ArrayCollection|RecipeIngredient[]
	 */
	public function getRecipeIngredients() {
		return $this->recipeIngredients;
	}

	/**
	 * @param ArrayCollection|RecipeIngredient[] $recipeIngredients
	 */
	public function setRecipeIngredients($recipeIngredients) {
		$this->recipeIngredients = $recipeIngredients;
	}

	public function addRecipeIngredient(RecipeIngredient $postIngredient) {
		$postIngredient->setRecipe($this);
		$this->recipeIngredients->add($postIngredient);
	}

	public function removeRecipeIngredient(RecipeIngredient $postIngredient) {
		$this->recipeIngredients->removeElement($postIngredient);
	}
}