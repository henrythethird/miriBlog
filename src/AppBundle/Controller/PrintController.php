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
}