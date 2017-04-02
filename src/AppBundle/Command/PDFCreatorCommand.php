<?php

namespace AppBundle\Command;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PDFCreatorCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:pdfcreator')
            ->setDescription('Creates pdf');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $post = $this->getContainer()->get('doctrine')
            ->getRepository(Post::class)
            ->find('3');

        $this->getContainer()->get('app_bundle.pdf')->generate($post);
    }
}
