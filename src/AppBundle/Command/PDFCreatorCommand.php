<?php

namespace AppBundle\Command;

use AppBundle\Entity\DownloadableInterface;
use AppBundle\Entity\PdfFile;
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

    private function generatePosts()
    {
        $this->generate(Post::class, 'post', 'print_view_post');
    }

    private function generateRecipes()
    {
        $this->generate(Recipe::class, 'recipe', 'print_view_recipe');
    }

    private function generate($classWithNamespace, $class, $route)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getManager();
        $objects = $entityManager
            ->getRepository($classWithNamespace)
            ->findAll();

        /** @var DownloadableInterface $object */
        foreach ($objects as $object) {
            if ($object->getPdfFile()) {
                continue;
            }

            $filePath = $this->generatePath(sprintf("%s_%s", $class, $object->getId()));

            $url = $this->getContainer()
                ->get('router')
                ->generate($route, ['id' => $object->getId()]);

            $this->getContainer()->get('app_bundle.pdf')->generate(
                $this->generateAbsoluteUrl($url),
                $filePath
            );

            $object->setPdfFile(new PdfFile($filePath));
        }

        $entityManager->flush();
    }

    private function generateAbsoluteUrl($offset)
    {
        return sprintf("%s%s", $this->getContainer()->getParameter('base_url'), $offset);
    }

    private function generatePath($offset)
    {
        return sprintf("%s/%s.pdf", $this->getContainer()->getParameter('pdf_path'), $offset);
    }
}
