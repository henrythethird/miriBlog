<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscribe")
 * @UniqueEntity("email", message="E-Mail address already in use")
 */
class Subscribe {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="UUID")
	 * @ORM\Column(type="guid")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", unique=true)
	 * @Assert\Email()
	 */
	private $email;

    /**
     * @ORM\Column(type="boolean")
     */
	private $active;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $date_created;

	public function __construct() {
	    $this->active = 0;
		$this->date_created = new \DateTime();
	}

	/**
	 * @return string
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

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
}