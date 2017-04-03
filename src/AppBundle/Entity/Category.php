<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="category")
 */
class Category {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $icon;

	/**
	 * @ORM\Column(type="string", length=128, unique=true)
	 * @Gedmo\Slug(fields={"name"})
	 */
	private $slug;

    /**
     * @var ArrayCollection|Post[]
     * @ORM\ManyToMany(
     *     targetEntity="AppBundle\Entity\Post", mappedBy="categories"
     * )
     */
    private $posts;

    public function __construct() {
        $this->posts = new ArrayCollection();
	    $this->icon = null;
    }

	/**
	 * @return string
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * @param string $icon
     * @return $this
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
        return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * @param mixed $slug
     * @return $this
	 */
	public function setSlug($slug) {
		$this->slug = $slug;
        return $this;
	}

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosts() {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     * @return $this
     */
    public function setPosts($posts) {
        $this->posts = $posts;
        return $this;
    }
    
    public function addPost(Post $post) {
        $this->posts->add($post);
        return $this;
    }

    public function removePost(Post $post) {
        $this->posts->remove($post);
        return $this;
    }

	public function __toString() {
		return $this->getName();
    }
}