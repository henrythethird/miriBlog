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
     * @ORM\ManyToOne(
     *     targetEntity="Application\Sonata\MediaBundle\Entity\Media",
     *     cascade={"persist"}
     * )
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
     * @ORM\ManyToMany(
     *     targetEntity="AppBundle\Entity\Category",
     *     inversedBy="posts",
     *     cascade={"persist", "remove"}
     * )
     */
    private $categories;

	/**
	 * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Recipe",
     *     mappedBy="post",
     *     cascade={"persist", "remove"}
     * )
	 */
	private $recipes;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="AppBundle\Entity\Tag",
     *     cascade={"persist", "remove"}
     * )
     */
	private $tags;


	public function __construct() {
		$this->dateCreated = new \DateTime();
		$this->recipes = new ArrayCollection();
		$this->categories = new ArrayCollection();
		$this->tags = new ArrayCollection();
	}

	/**
	 * @return Recipe[]|ArrayCollection
	 */
	public function getRecipes() {
		return $this->recipes;
	}

	/**
	 * @param Recipe[]|ArrayCollection $recipes
     * @return $this
	 */
	public function setRecipes($recipes) {
		$this->recipes = $recipes;
        return $this;
	}

	/**
	 * @param Recipe $recipe
     * @return $this
	 */
	public function addRecipe($recipe) {
		$recipe->setPost($this);
		$this->recipes->add($recipe);
        return $this;
	}

	/**
	 * @param Recipe $recipe
     * @return $this
	 */
	public function removeRecipe($recipe) {
		$this->recipes->removeElement($recipe);
        return $this;
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
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
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
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
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
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
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
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
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
     * @return $this
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
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
     * @return $this
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;
        return $this;
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
     * @return $this
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * @param Category[]|ArrayCollection $categories
     * @return $this
     */
    public function setCategory($categories) {
        $this->categories = $categories;
        return $this;
    }

    public function addCategory(Category $category)
    {
        $this->categories->add($category);
        return $this;
    }

    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
        return $this;
    }

    /**
     * @return Tag[]|ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function addTag(Tag $tag)
    {
        $this->tags->add($tag);
        return $this;
    }

    public function removeTag(Tag $tag)
    {
        $this->tags->add($tag);
        return $this;
    }

    /**
     * @param Tag[]|ArrayCollection $tags
     * @return Post
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
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
        return $this;
    }

	public function __toString() {
		return $this->getTitle();
    }
}