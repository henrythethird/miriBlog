<?php

namespace AppBundle\Service;

use AppBundle\Entity\Post;
use AppBundle\Entity\Subscribe;
use Doctrine\ORM\EntityManagerInterface;

class SubscribeService
{
    /**
     * @var MailService
     */
    private $mail;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager,
                                MailService $mail)
    {
        $this->mail = $mail;
        $this->entityManager = $entityManager;
    }

    public function dispatchMassEmails()
    {
        /** @var Subscribe[] $subscribes */
        $subscribes = $this->entityManager
            ->getRepository(Subscribe::class)
            ->findBy(['active' => true]);

        $posts = $this->entityManager
            ->getRepository(Post::class)
            ->findSubscribePosts();

        if (!count($posts)) {
            return;
        }

        $this->mail->sendUpdateMail($subscribes, $posts);
    }

    public function dispatchConfirmEmail(Subscribe $subscribe)
    {
        $this->mail->sendConfirmMail($subscribe);
    }
}