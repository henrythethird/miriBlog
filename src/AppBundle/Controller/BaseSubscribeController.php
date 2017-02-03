<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscribe;
use AppBundle\Form\SubscribeForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseSubscribeController extends Controller {
	protected function createSubscribeForm() {
		$subscribe = new Subscribe();
		$subscribeForm = $this->createForm(SubscribeForm::class, $subscribe, [
            'action' => $this->generateUrl('mail_subscribe'),
        ]);

		return $subscribeForm;
    }
}