<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $posts = $this->findArchiveResultsByOffset();

	    $categories = $this->getDoctrine()
		    ->getRepository(Category::class)
		    ->findAll();

	    return [
	    	'posts' => $posts,
		    'categories' => $categories,
		    'activeCategory' => $category,
	    ];
    }

	/**
	 * @Route("/archive/ajax/repopulate/{offset}", name="archive_ajax_repopulate")
	 */
	public function archiveRepopulateAction($offset = 1) {
		return new JsonResponse($this->findArchiveResultsByOffset($offset));
    }

	/**
	 * @param int $offset
	 * @return \AppBundle\Entity\Post[]
	 */
	private function findArchiveResultsByOffset($offset = 0) {
		return $this->getDoctrine()
			->getRepository(Post::class)
			->findArchiveResults($offset);
    }
}
