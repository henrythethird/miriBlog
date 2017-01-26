<?php

namespace AppBundle\Controller;

use AppBundle\Aggregate\Contact;
use AppBundle\Entity\Post;
use AppBundle\Form\ContactForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends BaseSubscribeController
{
    /**
     * @Route("/", name="home_index")
     * @Route("/blog", name="blog_index")
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
    public function aboutAction(Request $request)
    {
	    $contact = new Contact();

    	$contactForm = $this->createForm(ContactForm::class, $contact);
		$contactForm->handleRequest($request);

	    if ($contactForm->isSubmitted() && $contactForm->isValid()) {
		    $contact = $contactForm->getData();

		    $this->get('app_bundle.mail')
			    ->sendMessage($contact);

	    	$this->addFlash('success', "Contact request sent!");
	    	return $this->redirectToRoute('home_about');
	    }

        return [
        	'contactForm' => $contactForm->createView()
        ];
    }
}
