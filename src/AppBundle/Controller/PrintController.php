<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Router;

class PrintController extends Controller
{
    /**
     * @Route("/print/post/view/{slug}", name="print_view_post")
     * @Template("print/post.html.twig")
     */
    public function showPostAction(Post $post)
    {
        return [
            'post' => $post,
            'enableLinks' => false
        ];
    }

    /**
     * @Route("/print/recipe/view/{id}", name="print_view_recipe")
     * @Template("print/recipe.html.twig")
     */
    public function showRecipeAction(Recipe $recipe)
    {
        return [
            'recipe' => $recipe,
            'enableLinks' => false
        ];
    }

    /**
     * @Route("/print/post/pdf/{slug}", name="print_post")
     */
    public function printPostAction(Post $post)
    {
        return $this->printAction(
            sprintf("post_%s", $post->getSlug()),
            'print_view_post',
            ['slug' => $post->getSlug()]
        );
    }

    /**
     * @Route("/print/recipe/pdf/{id}", name="print_recipe")
     */
    public function printRecipeAction(Recipe $recipe)
    {
        return $this->printAction(
            sprintf("recipe_%s", $recipe->getId()),
            'print_view_recipe',
            ['id' => $recipe->getId()]
        );
    }

    private function printAction($slug, $route, $args)
    {
        $filePath = $this->generatePath($slug);

        $url = $this->get('router')->generate($route, $args);

        $this->get('app_bundle.pdf')->generate(
            $this->generateAbsoluteUrl($url),
            $filePath
        );

        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        return $response;
    }

    private function generateAbsoluteUrl($offset)
    {
        return sprintf("%s%s", $this->getParameter('base_url'), $offset);
    }

    private function generatePath($offset)
    {
        return sprintf("%s/%s.pdf", $this->getParameter('pdf_path'), $offset);
    }
}