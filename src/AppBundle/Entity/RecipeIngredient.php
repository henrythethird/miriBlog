<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $amount;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $position;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $unit;

    /**
     * @ORM\Column(type="boolean")
     */
	private $separatorAbove = false;

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * @param mixed $position
     * @return RecipeIngredient
	 */
	public function setPosition($position) {
		$this->position = $position;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * @param string $comment
     * @return RecipeIngredient
	 */
	public function setComment($comment) {
		$this->comment = $comment;
		return $this;
	}

	/**
	 * @return Recipe
	 */
	public function getRecipe() {
		return $this->recipe;
	}

	/**
	 * @param Recipe $recipe
     * @return RecipeIngredient
	 */
	public function setRecipe(Recipe $recipe) {
		$this->recipe = $recipe;
		return $this;
	}

	/**
	 * @return Ingredient
	 */
	public function getIngredient() {
		return $this->ingredient;
	}

	/**
	 * @param Ingredient $ingredient
     * @return RecipeIngredient
	 */
	public function setIngredient(Ingredient $ingredient) {
		$this->ingredient = $ingredient;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * @param float $amount
     * @return RecipeIngredient
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUnit() {
		return $this->unit;
	}

	/**
	 * @param string $unit
     * @return RecipeIngredient
     */
	public function setUnit($unit) {
		$this->unit = $unit;
		return $this;
	}

    /**
     * @return boolean
     */
    public function hasSeparatorAbove()
    {
        return $this->separatorAbove;
    }

    /**
     * @param boolean $separatorAbove
     * @return RecipeIngredient
     */
    public function setSeparatorAbove($separatorAbove)
    {
        $this->separatorAbove = $separatorAbove;
        return $this;
    }
}