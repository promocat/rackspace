<?php

namespace PromoCat\Rackspace;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware as GuzzleMiddleware;
use InvalidArgumentException;
use OpenStack\Common\Service\Builder;
use OpenStack\Common\Transport\HandlerStack;
use OpenStack\Common\Transport\Utils;
use OpenStack\ObjectStore\v1\Service as ObjectStoreService;
use OpenStack\OpenStack;
use PromoCat\Rackspace\Identity\Service;

class Rackspace extends OpenStack
{
    const US_IDENTITY_ENDPOINT = 'https://identity.api.rackspacecloud.com/v2.0/';
    const UK_IDENTITY_ENDPOINT = 'https://lon.identity.api.rackspacecloud.com/v2.0/';

    public function __construct(array $options = [], Builder $builder = null)
    {
        if (!isset($options['authUrl'])) {
            $options['authUrl'] = self::US_IDENTITY_ENDPOINT;
        }
        if (!isset($options['identityService'])) {
            $options['identityService'] = $this->getDefaultIdentityService($options);
        }

        parent::__construct($options, $builder);
    }

    private function getDefaultIdentityService(array $options): Service
    {
        if (!isset($options['authUrl'])) {
            throw new InvalidArgumentException("'authUrl' is a required option");
        }

        $stack = HandlerStack::create();

        if (!empty($options['debugLog']) && !empty($options['logger']) && !empty($options['messageFormatter'])) {
            $logMiddleware = GuzzleMiddleware::log($options['logger'], $options['messageFormatter']);
            $stack->push($logMiddleware, 'logger');
        }

        $clientOptions = [
            'base_uri' => Utils::normalizeUrl($options['authUrl']),
            'handler' => $stack,
        ];

        if (isset($options['requestOptions'])) {
            $clientOptions = array_merge($options['requestOptions'], $clientOptions);
        }

        return Service::factory(new Client($clientOptions));
    }

    /**
     * Creates a new Object Store v1 service.
     *
     * @param array $options options that will be used in configuring the service
     */
    public function objectStoreV1(array $options = []): ObjectStoreService
    {
        return parent::objectStoreV1($options + ['catalogName' => 'cloudFiles', 'catalogType' => 'object-store']);
    }
}
