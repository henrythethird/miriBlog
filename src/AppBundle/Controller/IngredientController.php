<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IngredientController extends Controller {
	/**
	 * @Route("/ingredient", name="ingredient_index")
	 * @Template("ingredient/index.html.twig")
	 */
	public function indexAction(Ingredient $ingredient = null) {
		$ingredients = $this->getDoctrine()
			->getRepository(Ingredient::class)
			->findBy([], ['name' => 'ASC']);

		return [
			'ingredients' => $ingredients,
			'currentIngredient' => $ingredient
		];
	}

	/**
	 * @Route("/ingredient/filter/{slug}", name="ingredient_filter")
	 * @Template("ingredient/filter.html.twig")
	 */
	public function filterAction(Ingredient $ingredient) {
		$posts = $this->getDoctrine()
			->getRepository(Post::class)
			->findByIngredient($ingredient);

		return [
			'posts' => $posts,
			'activeIngredient' => $ingredient
		];
	}
}