<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home_index")
     * @Template("home/index.html.twig")
     */
    public function indexAction()
    {
        $posts = [];/*$this->getDoctrine()
            ->getRepository(Post::class)
            ->findAllFirstPageResults();
*/
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
     * @Template("home/archive.html.twig")
     */
    public function archiveAction()
    {
        return [];
    }
}
