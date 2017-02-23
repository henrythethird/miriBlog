<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Recipe;
use AppBundle\Service\NutritionApiService;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class RecipeNutritionApiListener
{
    /**
     * @var NutritionApiService
     */
    private $api;

    public function __construct(NutritionApiService $apiService)
    {
        $this->api = $apiService;
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (!$entity instanceof Recipe) {
            return;
        }

        $entity->setNutritionCached(
            $this->api->fetch($entity, false)
        );
    }
}