<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Post;
use AppBundle\Entity\Recipe;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Sonata\MediaBundle\Provider\ImageProvider;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DomCrawler\Crawler;

class PostContentListener {
	/**
	 * @var ImageProvider
	 */
	private $imageProvider;

    /**
     * @var ContainerInterface
     */
	private $container;

	public function __construct(MediaProviderInterface $imageProvider, ContainerInterface $container) {
		$this->imageProvider = $imageProvider;
		$this->container = $container;
	}

	public function preUpdate(PreUpdateEventArgs $args) {
		$entity = $args->getEntity();
		if (!$entity instanceof Post &&
            !$entity instanceof Recipe) return;

		$domCrawler = new Crawler($entity->getContent());

		$images = $domCrawler->filter('img');

		/** @var \DOMElement $image */
		foreach ($images as $image) {
		    $this->processStyle($image);
            $this->processSrc($image);
		}

		$entity->setContent($domCrawler->html());
	}

	private function processStyle(\DOMElement $image) {
	    $style = $image->getAttribute('style');

	    $styles = explode(";", $style);

        $style = implode(";", array_filter($styles, function ($style) {
            return !preg_match("/^height/", trim($style));
        }));

        $image->setAttribute('style', trim($style));
    }

    private function processSrc(\DOMElement $image)
    {
        $fileName = basename($image->getAttribute('src'));

        /** @var Media $imageEntity */
        $imageEntity = $this->container
            ->get('doctrine')
            ->getRepository(Media::class)
            ->findOneBy(['providerReference' => $fileName]);

        if (!$imageEntity) return;

        $imagePath = $this->imageProvider->generatePublicUrl($imageEntity, 'default_big');

        $image->setAttribute('src', $imagePath);
    }
}