<?php

namespace AppBundle\Controller;


use AppBundle\Entity\MailArchive;
use AppBundle\Entity\Subscribe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MailController extends SubscribeController
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
        $subscribe->setActive(false);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', "Erfolgreich abgemeldet! Du wirst keine weiteren Nachrichten erhalten.");

        return $this->redirectToRoute('home_index');
    }

    /**
     * @Route("/mail/confirm/{id}", name="mail_confirm")
     */
    public function confirmAction(Subscribe $subscribe)
    {
        $subscribe->setActive(true);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', "Erfolgreich verifiziert! Du wirst Meldungen erhalten, wenn neue Beiträge erfasst werden.");

        return $this->redirectToRoute('home_index');
    }


    private function handleValidSubscribe(Form $subscribeForm)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entity = $subscribeForm->getData();

        $entityManager->persist($entity);
        $entityManager->flush();

        $this->addFlash('success', "Erfolgreich abonniert! Ein E-Mail mit einem Bestätigungslink ist unterwegs.");

        $this->sendConfirmationMail($entity);
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

        $this->addFlash('warning', "Die E-Mail-Adresse ist bereits registriert, aber deaktiviert. Ein neuer Bestätigungslink ist unterwegs.");
        $this->sendConfirmationMail($subscribe);
    }

    private function handleSubscribeErrors(Form $subscribeForm)
    {
        if (!$subscribeForm->getErrors(true)) return;

        foreach ($subscribeForm->getErrors(true) as $error) {
            $this->addFlash('danger', "Es gab einen Fehler beim abonnieren: ".$error->getMessage());
        }
    }

    private function sendConfirmationMail(Subscribe $subscribe)
    {
        $this->get('app_bundle.subscribe')->dispatchConfirmEmail($subscribe);
    }
}