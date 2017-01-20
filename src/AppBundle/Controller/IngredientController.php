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
	 * @Route("/ingredient/{slug}", name="ingredient_filter")
	 * @Template("ingredient/index.html.twig")
	 */
	public function indexAction(Ingredient $ingredient = null) {
		$letters = $this->getDoctrine()
			->getRepository(Ingredient::class)
			->findFirstLetters();

		$ingredients = $this->getDoctrine()
			->getRepository(Ingredient::class)
			->findBy([], ['name' => 'ASC']);

		$posts = $this->getDoctrine()
			->getRepository(Post::class)
			->findByIngredient($ingredient);

		return [
			'letters' => $letters,
			'ingredients' => $ingredients,
			'activeIngredient' => $ingredient,
			'posts' => $posts
		];
	}
}