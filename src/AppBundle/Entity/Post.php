<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 * @ORM\Table()
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     */
    private $picture;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePublished;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\PostIngredient", mappedBy="post", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(referencedColumnName="ingredient_id")
	 */
	private $postIngredients;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Step", mappedBy="post", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(referencedColumnName="post_id")
	 */
	private $steps;

	public function __construct() {
		$this->dateCreated = new \DateTime();
		$this->postIngredients = new ArrayCollection();
		$this->steps = new ArrayCollection();
	}

	/**
	 * @return Step[]|ArrayCollection
	 */
	public function getSteps() {
		return $this->steps;
	}

	/**
	 * @param Step[]|ArrayCollection $steps
	 */
	public function setSteps($steps) {
		$this->steps = $steps;
	}

	public function addStep(Step $step) {
		$step->setPost($this);
		$this->steps->add($step);
	}

	public function removeStep(Step $step) {
		$this->steps->removeElement($step);
	}

	/**
	 * @return ArrayCollection|PostIngredient[]
	 */
	public function getPostIngredients() {
		return $this->postIngredients;
	}

	/**
	 * @param ArrayCollection|PostIngredient[] $postIngredients
	 */
	public function setPostIngredients($postIngredients) {
		$this->postIngredients = $postIngredients;
	}

	public function addPostIngredient(PostIngredient $postIngredient) {
		$postIngredient->setPost($this);
		$this->postIngredients->add($postIngredient);
	}

	public function removePostIngredient(PostIngredient $postIngredient) {
		$this->postIngredients->removeElement($postIngredient);
	}

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return \DateTime
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * @param \DateTime $datePublished
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category) {
        $this->category = $category;
    }
}