<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IngredientController extends BaseSubscribeController  {
	/**
	 * @Route("/ingredient", name="ingredient_index")
	 * @Route("/ingredient/{slug}", name="ingredient_filter")
	 * @Template("ingredient/index.html.twig")
	 */
	public function indexAction(Ingredient $ingredient = null) {
		$ingredientRepository = $this->getDoctrine()
			->getRepository(Ingredient::class);

		$letters = $ingredientRepository->findFirstLetters();
		$ingredients = $ingredientRepository->findBy([], ['name' => 'ASC']);

		$posts = $this->getDoctrine()
			->getRepository(Post::class)
			->findByIngredient($ingredient);

		return [
			'letters' => $letters,
			'ingredients' => $ingredients,
			'activeIngredient' => $ingredient,
			'posts' => $posts,
			'subscribeForm' => $this->createSubscribeForm()->createView()
		];
	}
}