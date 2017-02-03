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
            $this->handleValidSubscribe($subscribeForm);
        } else {
            $this->handleValidationErrors($subscribeForm);
        }

        return $this->redirect($request->headers->get('referer'));
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


    private function handleValidSubscribe(Form $subscribeForm)
    {
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('success', "Successfully subscribed! An email with a confirmation link has been sent to you");
        $this->sendConfirmationMail($subscribeForm->getData());
    }

    /**
     * @param Form $subscribeForm
     */
    private function handleValidationErrors(Form $subscribeForm)
    {
        $email = $subscribeForm->get('email')->getData();
        $subscribe = $this->getDoctrine()->getRepository(Subscribe::class)
            ->findOneBy([
                'email' => $email,
                'active' => false
            ]);

        if (!$subscribe) {
            $this->handleSubscribeErrors($subscribeForm);
            return;
        }

        $this->addFlash('warning', "The email address is in use but deactivated. Resending confirmation link.");
        $this->sendConfirmationMail($subscribe);
    }

    private function handleSubscribeErrors(Form $subscribeForm)
    {
        if (!$subscribeForm->getErrors(true)) return;

        foreach ($subscribeForm->getErrors(true) as $error) {
            $this->addFlash('danger', "There was an error when you tried to subscribe: ".$error->getMessage());
        }
    }

    private function sendConfirmationMail(Subscribe $subscribe)
    {
        $this->get('app_bundle.subscribe')->dispatchConfirmEmail($subscribe);
    }
}