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
	 * @ORM\Column(type="string")
	 */
	private $description;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recipe", inversedBy="steps")
	 * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
	 */
	private $recipe;

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