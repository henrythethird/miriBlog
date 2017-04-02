<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscribe;
use AppBundle\Form\SubscribeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeController extends Controller {
    /**
     * @Route("/subscribeForm", name="subscribe_form")
     * @Template("subscribe/form.html.twig")
     */
	public function subscribeFormAction() {
		return [
		    'subscribeForm' => $this->createSubscribeForm()->createView()
        ];
    }

    /**
     * @return Form
     */
    protected function createSubscribeForm() {
        $subscribe = new Subscribe();
        $subscribeForm = $this->createForm(SubscribeForm::class, $subscribe, [
            'action' => $this->generateUrl('mail_subscribe'),
        ]);

        return $subscribeForm;
    }
}