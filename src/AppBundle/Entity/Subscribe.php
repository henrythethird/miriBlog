<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscribe")
 * @UniqueEntity("email")
 */
class Subscribe {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", unique=true)
	 * @Assert\Email()
	 */
	private $email;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date_created;

	public function __construct() {
		$this->date_created = new \DateTime();
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return \DateTime
	 */
	public function getDateCreated() {
		return $this->date_created;
	}

	/**
	 * @param \DateTime $date_created
	 */
	public function setDateCreated($date_created) {
		$this->date_created = $date_created;
	}
}