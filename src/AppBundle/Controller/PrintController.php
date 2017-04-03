<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PdfFile;
use AppBundle\Entity\Post;
use AppBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class PrintController extends Controller
{
    /**
     * @Route("/print/post/view/{id}", name="print_view_post")
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
     * @Route("/print/pdf/download/{id}", name="print_download")
     */
    public function downloadPdfAction(PdfFile $file)
    {
        $response = new BinaryFileResponse($file->getPath());
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
    }
}