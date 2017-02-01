<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @Doctrine\ORM\Mapping\Entity
 * @Doctrine\ORM\Mapping\Table(name="category")
 */
class Category {
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
	 * @ORM\Column(type="string")
	 */
	private $color;

	/**
	 * @ORM\Column(type="string", length=128, unique=true)
	 * @Gedmo\Slug(fields={"name"})
	 */
	private $slug;

    /**
     * @var ArrayCollection|Post[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Post", mappedBy="categories")
     */
    private $posts;

    public function __construct() {
        $this->posts = new ArrayCollection();
	    $this->color = "#ff00ff";
    }

	/**
	 * @return string
	 */
	public function getColor() {
		return $this->color;
	}

	/**
	 * @param string $color
	 */
	public function setColor($color) {
		$this->color = $color;
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
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPosts() {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts) {
        $this->posts = $posts;
    }
    
    public function addPost(Post $post) {
        $this->posts->add($post);
    }

    public function removePost(Post $post) {
        $this->posts->remove($post);
    }

	public function __toString() {
		return $this->getName();
    }
}