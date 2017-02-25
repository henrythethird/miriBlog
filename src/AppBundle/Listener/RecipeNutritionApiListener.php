<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Recipe;
use AppBundle\Service\NutritionApiService;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Monolog\Logger;

class RecipeNutritionApiListener
{
    /**
     * @var NutritionApiService
     */
    private $api;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(NutritionApiService $apiService, Logger $logger)
    {
        $this->api = $apiService;
        $this->logger = $logger;
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (!$entity instanceof Recipe) {
            return;
        }

        try {
            $entity->setNutritionCached(
                $this->api->fetch($entity, false)
            );
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage(), [
                'cause' => $exception->getTraceAsString()
            ]);
        }
    }
}