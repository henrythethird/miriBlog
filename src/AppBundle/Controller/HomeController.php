<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home_index")
     * @Template("home/index.html.twig")
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAllFirstPageResults();

	    return [
            'posts' => $posts
	    ];
    }

    /**
     * @Route("/about", name="home_about")
     * @Template("home/about.html.twig")
     */
    public function aboutAction()
    {
        return [];
    }

    /**
     * @Route("/archive", name="home_archive")
     * @Route("/archive/{slug}", name="home_archive_slug")
     * @Template("home/archive.html.twig")
     */
    public function archiveAction(Category $category = null)
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findArchiveResults(0);

	    $categories = $this->getDoctrine()
		    ->getRepository(Category::class)
		    ->findAll();

	    return [
	    	'posts' => $posts,
		    'categories' => $categories,
		    'activeCategory' => $category,
	    ];
    }
}
