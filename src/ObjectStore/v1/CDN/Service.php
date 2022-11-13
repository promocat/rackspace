<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1\CDN;

use OpenStack\Common\Error\BadResponseError;
use OpenStack\Common\Service\AbstractService;
use PromoCat\Rackspace\ObjectStore\v1\CDN\Models\Container;

class Service extends AbstractService
{
    /**
     * Retrieves a collection of container resources in a generator format.
     *
     * @param array $options {@see \OpenStack\ObjectStore\v1\Api::getAccount}
     * @param callable|null $mapFn allows a function to be mapped over each element in the collection
     */
    public function listContainers(array $options = [], callable $mapFn = null): \Generator
    {
        $options = array_merge($options, ['format' => 'json']);

        return $this->model(Container::class)->enumerate($this->api->getAccount(), $options, $mapFn);
    }

    public function getContainer(string $name = null): Container
    {
        /** @var Container $container */
        $container = $this->model(Container::class, ['name' => $name]);
        $container->retrieve();

        return $container;
    }

    /**
     * @throws BadResponseError Thrown for any non 404 status error
     */
    public function containerExists(string $name): bool
    {
        try {
            $this->execute($this->api->headContainer(), ['name' => $name]);

            return true;
        } catch (BadResponseError $e) {
            if (404 === $e->getResponse()->getStatusCode()) {
                return false;
            }
            throw $e;
        }
    }
}
