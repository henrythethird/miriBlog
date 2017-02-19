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
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $hint;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $invert_hint = false;

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

	/**
	 * @return string
	 */
	public function getHint() {
		return $this->hint;
	}

	/**
	 * @param string $hint
	 */
	public function setHint($hint) {
		$this->hint = $hint;
	}

	/**
	 * @return boolean
	 */
	public function getInvertHint() {
		return $this->invert_hint;
	}

	/**
	 * @param boolean $invert_hint
	 */
	public function setInvertHint($invert_hint) {
		$this->invert_hint = $invert_hint;
	}
}