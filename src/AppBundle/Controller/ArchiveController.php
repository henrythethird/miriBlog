<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Post;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ArchiveController extends Controller {

	/**
	 * @Route("/archive", name="home_archive")
	 * @Route("/archive/{slug}", name="home_archive_slug")
	 * @Template("archive/archive.html.twig")
	 */
	public function archiveAction(Category $filterCategory = null)
	{
		$posts = $this->getDoctrine()
			->getRepository(Post::class)
			->findArchiveResults($filterCategory);

		$categories = $this->getDoctrine()
			->getRepository(Category::class)
			->findBy([], ['name' => 'ASC']);

		$aggregate = [];
		foreach ($posts as $post) {
			$aggregate[
				$post->getDatePublished()->format('Y')
			][
				$post->getDatePublished()->format('m')
			][] = $post;
		}

		return [
			'posts' => $posts,
			'categories' => $categories,
			'activeCategory' => $filterCategory,
			'archive' => $aggregate
		];
	}

	/**
	 * @Route("/archive/ajax/repopulate/{offset}", name="archive_ajax_repopulate")
	 * @Route("/archive/ajax/repopulate/{offset}/{slug}", name="archive_ajax_repopulate")
	 * @Template("archive/batch.html.twig")
	 */
	public function archiveRepopulateAction($offset, Category $filterCategory = null) {
		$archiveAggregate = $this->getDoctrine()
			->getRepository(Post::class)
			->findArchiveResultsPaginator($offset);

		return new JsonResponse([
			'view' => $this->renderView('archive/batch.html.twig', [
				'posts' => $archiveAggregate->getData()
			]),
			'count' => $archiveAggregate->getCount()
		]);
	}
}