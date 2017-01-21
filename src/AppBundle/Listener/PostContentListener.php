<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Post;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Sonata\MediaBundle\Provider\ImageProvider;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Component\DomCrawler\Crawler;

class PostContentListener {
	/**
	 * @var ImageProvider
	 */
	private $imageProvider;

	public function __construct(MediaProviderInterface $imageProvider) {
		$this->imageProvider = $imageProvider;
	}

	public function preUpdate(PreUpdateEventArgs $args) {
		$post = $args->getEntity();
		if (!$post instanceof Post) return;

		$domCrawler = new Crawler($post->getContent());

		$images = $domCrawler->filter('img');

		/** @var \DOMElement $image */
		foreach ($images as $image) {
			$fileName = basename($image->getAttribute('src'));

			$imageEntity = $args->getEntityManager()
				->getRepository(Media::class)
				->findOneBy(['providerReference' => $fileName]);

			if (!$imageEntity) continue;

			$imagePath = $this->imageProvider->generatePublicUrl($imageEntity, 'default_big');

			$image->setAttribute('src', $imagePath);
		}

		$post->setContent($domCrawler->html());
	}
}