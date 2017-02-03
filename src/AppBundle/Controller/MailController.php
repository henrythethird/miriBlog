<?php

namespace AppBundle\Controller;


use AppBundle\Entity\MailArchive;
use AppBundle\Entity\Subscribe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{
    /**
     * @Route("/mail/view/{id}", name="mail_view")
     */
    public function viewAction(MailArchive $archive)
    {
        return new Response($archive->getContent());
    }

    /**
     * @Route("/mail/unsubscribe/{id}", name="mail_unsubscribe")
     */
    public function unsubscribeAction(Subscribe $subscribe)
    {
        $subscribe->setActive(false);
        $this->getDoctrine()->getManager()->flush();

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