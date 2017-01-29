<?php

namespace AppBundle\Command;

use AppBundle\Entity\ContentInterface;
use AppBundle\Entity\Post;
use AppBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OptimizePostsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:optimize_posts')
            ->setDescription('Optimizes the posts (content)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');

        /** @var ContentInterface[] $contentEntities */
        $contentEntities = array_merge(
            $entityManager->getRepository(Post::class)->findAll(),
            $entityManager->getRepository(Recipe::class)->findAll()
        );

        foreach ($contentEntities as $contentEntity) {
            $this->getContainer()->get('app_bundle.content_optimizer')->optimize($contentEntity);
        }

        $entityManager->flush();
    }
}
