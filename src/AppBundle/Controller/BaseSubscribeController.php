<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscribe;
use AppBundle\Form\SubscribeForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseSubscribeController extends Controller {
	protected function handleSubscribe(Request $request) {
		$entityManager = $this->getDoctrine()->getManager();

		$subscribe = new Subscribe();
		$subscribeForm = $this->createForm(SubscribeForm::class, $subscribe);
		$subscribeForm->handleRequest($request);

		if ($subscribeForm->isSubmitted() && $subscribeForm->isValid()) {
			$subscribe = $subscribeForm->getData();

			$entityManager->persist($subscribe);
			$entityManager->flush();

			$this->addFlash('success', "Successfully Subscribed");

			return $this->redirectToRoute('home_index');
		}

		return $subscribeForm;
	}
}