<?php

namespace AppBundle\Controller;

use AppBundle\Aggregate\PostAggregate;
use AppBundle\Entity\Subscribe;
use AppBundle\Form\SubscribeForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseSubscribeController extends Controller {
	protected function createSubscribeForm() {
		$subscribe = new Subscribe();
		$subscribeForm = $this->createForm(SubscribeForm::class, $subscribe, [
            'action' => $this->generateUrl('mail_subscribe'),
        ]);

		return $subscribeForm;
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