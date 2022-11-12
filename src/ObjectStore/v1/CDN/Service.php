<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1\CDN;

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

    public function cdnContainer($data)
    {
        return $this->model(Container::class, $data);
    }
}
