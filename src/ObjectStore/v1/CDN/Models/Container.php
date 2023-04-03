<?php

namespace PromoCat\Rackspace\ObjectStore\v1\CDN\Models;

use GuzzleHttp\Psr7\Utils;
use OpenStack\Common\Resource\Listable;
use OpenStack\Common\Resource\OperatorResource;
use OpenStack\Common\Resource\Retrievable;
use PromoCat\Rackspace\ObjectStore\v1\CDN\Api;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * @property Api $api
 */
class Container extends OperatorResource implements Listable, Retrievable
{
    public string $name;

    public string $cdnSslUri;

    public string $cdnUri;

    public bool $cdnEnabled;

    public int $ttl;

    public bool $logRetention;

    public array $metadata;

    protected $markerKey = 'name';

    protected $aliases = [
        'cdn_ssl_uri' => 'cdnSslUri',
        'cdn_uri' => 'cdnUri',
        'cdn_enabled' => 'cdnEnabled',
        'log_retention' => 'logRetention',
    ];

    public function getCdnSslUri(): UriInterface
    {
        return Utils::uriFor($this->cdnSslUri);
    }

    public function getCdnUri(): UriInterface
    {
        return Utils::uriFor($this->cdnUri);
    }

    public function isCdnEnabled(): bool
    {
        return $this->cdnEnabled;
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve()
    {
        $response = $this->executeWithState($this->api->headContainer());
        $this->populateFromResponse($response);
    }

    public function populateFromResponse(ResponseInterface $response)
    {
        parent::populateFromResponse($response);

        $this->cdnSslUri = $response->getHeaderLine('X-Cdn-Ssl-Uri');
        $this->cdnUri = $response->getHeaderLine('X-Cdn-Uri');
        $this->cdnEnabled = $response->getHeaderLine('X-Cdn-Enabled') === 'True';
        $this->ttl = $response->getHeaderLine('X-Ttl');
        $this->logRetention = $response->getHeaderLine('X-Log-Retention');
    }
}
