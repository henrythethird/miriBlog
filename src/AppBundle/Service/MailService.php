<?php

namespace AppBundle\Service;

use AppBundle\Entity\MailArchive;
use AppBundle\Entity\Post;
use AppBundle\Entity\Subscribe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;

class MailService
{
    const SUBJECT_UPDATE = 'We just added some new content - Subscription updates';
    const SUBJECT_CONFIRM = 'Welcome - Please confirm your subscription';
    const FROM_ADDRESS = 'info@kuchenkruemel.ch';

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TwigEngine
     */
    private $templating;

    public function __construct(\Swift_Mailer $mailer,
                                TwigEngine $templating,
                                EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->entityManager = $entityManager;
    }

    public function sendConfirmMail(Subscribe $subscribe)
    {
        $this->sendMessage(self::SUBJECT_CONFIRM, [$subscribe], 'mail/confirm.html.twig');
    }

    /**
     * @param Subscribe[] $subscribes
     * @param Post[] $posts
     */
    public function sendUpdateMail($subscribes, $posts)
    {
        $this->sendMessage(self::SUBJECT_UPDATE, $subscribes, 'mail/update.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @param string $subject
     * @param array $templateArgs
     * @param Subscribe[] $subscribes
     * @param string $template
     */
    private function sendMessage($subject, $subscribes, $template, $templateArgs = [])
    {
        foreach ($subscribes as $subscribe) {
            $address = $subscribe->getEmail();
            $archiveItem = $this->createArchiveEntry($address);
            $content = $this->renderTemplate($template, $templateArgs, $archiveItem, $subscribe);
            $archiveItem->setContent($content);

            $message = new \Swift_Message($subject);
            $message->setBody($content, 'text/html');
            $message->setFrom(self::FROM_ADDRESS);
            $message->setTo($address);

            $this->mailer->send($message);
        }
        $this->entityManager->flush();
    }

    private function createArchiveEntry($mail)
    {
        $archiveItem = new MailArchive($mail);
        $this->entityManager->persist($archiveItem);

        return $archiveItem;
    }

    private function renderTemplate($template, $templateArgs, MailArchive $archiveItem, Subscribe $subscribe)
    {
        return $this->templating->render($template, array_merge($templateArgs, [
            'title' => self::SUBJECT_UPDATE,
            'archiveUuid' => $archiveItem->getId(),
            'subscribeUuid' => $subscribe->getId(),
        ]));
    }
}