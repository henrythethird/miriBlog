<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends BaseSubscribeController
{
    /**
     * @Route("/blog/{slug}", name="blog_post")
     * @Template("blog/post.html.twig")
     */
    public function postController(Post $post)
    {
		return [
			'post' => $post,
			'subscribeForm' => $this->createSubscribeForm()->createView()
		];
    }
}