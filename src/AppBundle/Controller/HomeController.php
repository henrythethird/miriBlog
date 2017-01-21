<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends BaseSubscribeController
{
    /**
     * @Route("/", name="home_index")
     * @Template("home/index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAllFirstPageResults();

	    $recentPosts = $this->getDoctrine()
		    ->getRepository(Post::class)
		    ->findRecentPosts();

		$subscribeForm = $this->handleSubscribe($request);

	    if ($subscribeForm instanceof Response) {
	    	return $subscribeForm;
	    }

	    return [
            'posts' => $posts,
		    'recentPosts' => $recentPosts,
		    'subscribeForm' => $subscribeForm->createView()
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
}
