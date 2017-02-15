<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 * @ORM\Table()
 */
class Post implements ContentInterface
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateMailPublished;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category", inversedBy="posts", cascade={"persist", "remove"})
     */
    private $categories;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Recipe", mappedBy="post", cascade={"persist", "remove"})
	 */
	private $recipes;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AlternateLink", mappedBy="post")
     */
	private $alternateLinks;

	public function __construct() {
		$this->dateCreated = new \DateTime();
		$this->recipes = new ArrayCollection();
		$this->categories = new ArrayCollection();
	}

	/**
	 * @return Recipe[]|ArrayCollection
	 */
	public function getRecipes() {
		return $this->recipes;
	}

	/**
	 * @param Recipe[]|ArrayCollection $recipes
	 */
	public function setRecipes($recipes) {
		$this->recipes = $recipes;
	}

	/**
	 * @param Recipe $recipe
	 */
	public function addRecipe($recipe) {
		$recipe->setPost($this);
		$this->recipes->add($recipe);
	}

	/**
	 * @param Recipe $recipe
	 */
	public function removeRecipe($recipe) {
		$this->recipes->removeElement($recipe);
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
     * @return MediaInterface
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param MediaInterface $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * @param Category[] $categories
     */
    public function setCategory($categories) {
        $this->categories = $categories;
    }

    public function addCategory(Category $category)
    {
        $this->categories->add($category);
    }

    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * @return \DateTime
     */
    public function getDateMailPublished()
    {
        return $this->dateMailPublished;
    }

    public function setDateMailPublished(\DateTime $dateMailPublished = null)
    {
        $this->dateMailPublished = $dateMailPublished;
    }

	public function __toString() {
		return $this->getTitle();
    }
}