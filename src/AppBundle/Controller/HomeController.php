<?php

namespace AppBundle\Controller;

use AppBundle\Aggregate\Contact;
use AppBundle\Aggregate\PostAggregate;
use AppBundle\Entity\Post;
use AppBundle\Form\ContactForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home_index")
     * @Route("/blog", name="blog_index")
     * @Template("home/index.html.twig")
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAllFirstPageResults();

	    $recentPosts = $this->getDoctrine()
		    ->getRepository(Post::class)
		    ->findRecentPosts();

	    return [
            'posts' => $posts,
		    'recentPosts' => $recentPosts,
	    ];
    }

	/**
	 * @Route("/repopulate/{offset}", name="index_repopulate")
	 * @Route("/repopulate/", name="index_repopulate_sans")
	 */
	public function indexRepopulate($offset = 0)
	{
		$postAggregate = $this->getDoctrine()
			->getRepository(Post::class)
			->findAllFirstPageResultsPaginator($offset);

		return $this->createPaginatorResponse(
			"home/batch.html.twig",
			$postAggregate
		);
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

		    $this->get('app_bundle.contact')
			    ->sendMessage($contact);

	    	$this->addFlash('success', "Contact request sent!");
	    	return $this->redirectToRoute('home_about');
	    }

        return [
        	'contactForm' => $contactForm->createView()
        ];
    }

    protected function createPaginatorResponse($view, PostAggregate $postAggregate) {
        return new JsonResponse([
            'view' => $this->renderView($view, [
                'posts' => $postAggregate->getData()
            ]),
            'count' => $postAggregate->getCount()
        ]);
    }
}
