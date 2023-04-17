<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1\CDN;

class Api extends \OpenStack\ObjectStore\v1\Api
{
    public function __construct()
    {
        $this->params = new Params();
    }

    public function putContainer(): array
    {
        return [
            'method' => 'PUT',
            'path' => '{name}',
            'params' => [
                'name' => $this->params->containerName(),
                'cdnEnabled' => $this->params->cdnEnabled(),
                'ttl' => $this->params->ttl(),
            ],
        ];
    }
}
