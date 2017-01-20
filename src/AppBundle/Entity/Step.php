<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="step")
 */
class Step {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="text")
	 */
	private $description;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recipe", inversedBy="steps")
	 * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
	 */
	private $recipe;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $position;

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getRecipe() {
		return $this->recipe;
	}

	/**
	 * @return mixed
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * @param mixed $position
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	/**
	 * @param mixed $recipe
	 */
	public function setRecipe($recipe) {
		$this->recipe = $recipe;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
}