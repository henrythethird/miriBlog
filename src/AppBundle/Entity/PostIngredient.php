<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="post_ingredients")
 */
class PostIngredient {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ingredient", inversedBy="postIngredients")
	 * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")
	 */
	private $ingredient;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post", inversedBy="postIngredients")
	 * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
	 */
	private $post;

	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	private $amount;

	/**
	 * @ORM\Column(type="string")
	 */
	private $description;

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return Post
	 */
	public function getPost() {
		return $this->post;
	}

	/**
	 * @param Post $post
	 */
	public function setPost(Post $post) {
		$this->post = $post;
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
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
}