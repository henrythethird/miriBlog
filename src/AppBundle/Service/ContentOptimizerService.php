<?php

namespace AppBundle\Service;

use AppBundle\Entity\ContentInterface;
use Doctrine\ORM\EntityManager;
use Sonata\MediaBundle\Provider\ImageProvider;
use Application\Sonata\MediaBundle\Entity\Media;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Component\DomCrawler\Crawler;

class ContentOptimizerService
{
    const BIG_THUMB = 'default_big';

    /**
     * @var ImageProvider
     */
    private $imageProvider;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(MediaProviderInterface $imageProvider, EntityManager $entityManager)
    {
        $this->imageProvider = $imageProvider;
        $this->entityManager = $entityManager;
    }

    public function optimize(ContentInterface $entity)
    {
        $domCrawler = new Crawler();
        $domCrawler->addHtmlContent($entity->getContent(), 'UTF-8');

        $images = $domCrawler->filter('img');

        if (!$images->count()) {
            return;
        }

        /** @var \DOMElement $image */
        foreach ($images as $image) {
            $this->processStyle($image);
            $this->processSrc($image);
        }

        $entity->setContent($domCrawler->html());
    }


    private function processStyle(\DOMElement $image)
    {
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
        $imageEntity = $this->entityManager
            ->getRepository(Media::class)
            ->findOneBy(['providerReference' => $fileName]);

        if (!$imageEntity) return;

        $imagePath = $this->imageProvider->generatePublicUrl($imageEntity, self::BIG_THUMB);

        $image->setAttribute('src', $imagePath);
    }
}