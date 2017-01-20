<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe_ingredients")
 */
class RecipeIngredient {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ingredient", inversedBy="recipeIngredients")
	 * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")
	 */
	private $ingredient;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recipe", inversedBy="recipeIngredients")
	 * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
	 */
	private $recipe;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $comment;

	/**
	 * @ORM\Column(type="string")
	 */
	private $amount;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $unit;

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * @param string $comment
	 */
	public function setComment($comment) {
		$this->comment = $comment;
	}

	/**
	 * @return Recipe
	 */
	public function getRecipe() {
		return $this->recipe;
	}

	/**
	 * @param Recipe $recipe
	 */
	public function setRecipe(Recipe $recipe) {
		$this->recipe = $recipe;
	}

	/**
	 * @return Ingredient
	 */
	public function getIngredient() {
		return $this->ingredient;
	}

	/**
	 * @param Ingredient $ingredient
	 */
	public function setIngredient(Ingredient $ingredient) {
		$this->ingredient = $ingredient;
	}

	/**
	 * @return float
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * @param float $amount
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
	}

	/**
	 * @return string
	 */
	public function getUnit() {
		return $this->unit;
	}

	/**
	 * @param string $unit
	 */
	public function setUnit($unit) {
		$this->unit = $unit;
	}
}