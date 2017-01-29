<?php

namespace AppBundle\Listener;

use AppBundle\Entity\ContentInterface;
use AppBundle\Entity\Post;
use AppBundle\Entity\Recipe;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PostContentListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        /** @var ContentInterface $entity */
        $entity = $args->getEntity();
        if (!$entity instanceof Post &&
            !$entity instanceof Recipe
        ) return;

        $this->container->get('app_bundle.content_optimizer')
            ->optimize($entity);
    }
}