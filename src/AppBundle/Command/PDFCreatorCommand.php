<?php

namespace AppBundle\Command;

use AppBundle\Entity\Post;
use AppBundle\Entity\Recipe;
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
        $this->generatePosts();
        $this->generateRecipes();
    }

    private function generateAbsoluteUrl($offset)
    {
        return sprintf("%s%s", $this->getContainer()->getParameter('base_url'), $offset);
    }

    private function generatePath($offset)
    {
        return sprintf("%s/%s.pdf", $this->getContainer()->getParameter('pdf_path'), $offset);
    }

    private function generatePosts()
    {
        /** @var Post[] $posts */
        $posts = $this->getContainer()->get('doctrine')
            ->getRepository(Post::class)
            ->findAll();

        foreach ($posts as $post) {
            $filePath = $this->generatePath(sprintf("post_%s", $post->getSlug()));

            $url = $this->getContainer()
                ->get('router')
                ->generate('print_view_post', ['slug' => $post->getSlug()]);

            $this->getContainer()->get('app_bundle.pdf')->generate(
                $this->generateAbsoluteUrl($url),
                $filePath
            );
        }
    }

    private function generateRecipes()
    {
        /** @var Recipe[] $posts */
        $posts = $this->getContainer()->get('doctrine')
            ->getRepository(Recipe::class)
            ->findAll();

        foreach ($posts as $post) {
            $filePath = $this->generatePath(sprintf("recpie_%s", $post->getId()));

            $url = $this->getContainer()
                ->get('router')
                ->generate('print_view_recipe', ['id' => $post->getId()]);

            $this->getContainer()->get('app_bundle.pdf')->generate(
                $this->generateAbsoluteUrl($url),
                $filePath
            );
        }
    }
}
