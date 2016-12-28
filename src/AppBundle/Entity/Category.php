<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;

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
     * @Doctrine\ORM\Mapping\Column(type="string")
     */
    private $name;

    /**
     * @var ArrayCollection|Post[]
     * @OneToMany(targetEntity="AppBundle\Entity\Post", mappedBy="category")
     */
    private $posts;

    public function __construct() {
        $this->posts = new ArrayCollection();
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
}