<?php

namespace PromoCat\Rackspace\Identity;

use GuzzleHttp\ClientInterface;
use OpenStack\Identity\v2\Service as OpenStackService;
use PromoCat\Identity\Api;

class Service extends OpenStackService
{
    public static function factory(ClientInterface $client): self
    {
        return new static($client, new Api());
    }
}
