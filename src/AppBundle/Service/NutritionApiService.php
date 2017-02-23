<?php

namespace AppBundle\Service;

use AppBundle\Entity\Recipe;
use GuzzleHttp\Client;

class NutritionApiService
{
    /**
     * @var Client
     */
    private $client;

    private $endpoint;

    public function __construct(Client $client, $endpoint)
    {
        $this->client = $client;
        $this->endpoint = $endpoint;
    }

    /**
     * @param Recipe $recipe
     * @param bool $cache
     * @throws \Exception
     * @return string
     */
    public function fetch(Recipe $recipe, $cache = true)
    {
        if (!$recipe->getNutritionId()) {
            return "";
        }

        if ($recipe->getNutritionCached() && $cache) {
            return $recipe->getNutritionCached();
        }

        return $this->client
            ->get($this->constructUri(10580))
            ->getBody()
            ->getContents();
    }

    private function constructUri($id)
    {
        return sprintf("%s/%s", $this->endpoint, $id);
    }
}