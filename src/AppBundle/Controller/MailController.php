<?php

namespace AppBundle\Controller;


use AppBundle\Entity\MailArchive;
use AppBundle\Entity\Subscribe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;

class MailController extends BaseSubscribeController
{
    /**
     * @Route("/mail/view/{id}", name="mail_view")
     */
    public function viewAction(MailArchive $archive)
    {
        return new Response($archive->getContent());
    }

    /**
     * @Route("/mail/subscribe/", name="mail_subscribe")
     */
    public function subscribeAction(Request $request)
    {
        $subscribeForm = $this->createSubscribeForm();

        $subscribeForm->handleRequest($request);
        if ($subscribeForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "Successfully subscribed! An email with a confirmation link has been sent to you");
        }

        $this->handleSubscribeErrors($subscribeForm);

        return $this->redirect($request->headers->get('referer'));
    }

    private function handleSubscribeErrors(Form $subscribeForm)
    {
        if (!$subscribeForm->getErrors(true)) return;

        foreach ($subscribeForm->getErrors(true) as $error) {
            $this->addFlash('error', "There was an error when you tried to subscribe: ".$error->getMessage());
        }
    }

    /**
     * @Route("/mail/unsubscribe/{id}", name="mail_unsubscribe")
     */
    public function unsubscribeAction(Subscribe $subscribe)
    {
        $this->getDoctrine()->getManager()->remove($subscribe);

        $this->addFlash('success', "Successfully unsubscribed! You will not receive any more messages.");

        return $this->redirectToRoute('home_index');
    }

    /**
     * @Route("/mail/confirm/{id}", name="mail_confirm")
     */
    public function confirmAction(Subscribe $subscribe)
    {
        $subscribe->setActive(true);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', "Successfully confirmed! You will now be notified of new content.");

        return $this->redirectToRoute('home_index');
    }
}