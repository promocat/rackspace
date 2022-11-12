<?php

namespace PromoCat\Rackspace\ObjectStore\v1\CDN\Models;

use OpenStack\Common\Resource\HasMetadata;
use OpenStack\Common\Resource\Listable;
use OpenStack\Common\Resource\OperatorResource;
use OpenStack\ObjectStore\v1\Models\MetadataTrait;
use PromoCat\Rackspace\ObjectStore\v1\CDN\Api;
use Psr\Http\Message\ResponseInterface;

/**
 * @property Api $api
 */
class Container extends OperatorResource implements Listable, HasMetadata
{
    const METADATA_PREFIX = 'X-Cdn-';

    use MetadataTrait;

    /** @var string */
    public $name;

    /** @var int */
    public $ttl;

    /** @var array */
    public $metadata;

    protected $markerKey = 'name';

    /**
     * {@inheritdoc}
     */
    public function populateFromResponse(ResponseInterface $response): self
    {
        parent::populateFromResponse($response);

        $this->ttl = $response->getHeaderLine('X-Ttl');
        $this->metadata = $this->parseMetadata($response);

        return $this;
    }

    /**
     * @return null|string|int
     */
    public function getCdnSslUri()
    {
        return $this->metadata['Ssl-Uri'];
    }

    /**
     * @return null|string|int
     */
    public function getCdnUri()
    {
        return $this->metadata['Uri'];
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * {@inheritdoc}
     */
    public function mergeMetadata(array $metadata)
    {
        $response = $this->execute($this->api->postContainer(), ['name' => $this->name, 'metadata' => $metadata]);
        $this->metadata = $this->parseMetadata($response);
    }

    /**
     * {@inheritdoc}
     */
    public function resetMetadata(array $metadata)
    {
        $options = [
            'name' => $this->name,
            'removeMetadata' => [],
            'metadata' => $metadata,
        ];

        foreach ($this->getMetadata() as $key => $val) {
            if (!array_key_exists($key, $metadata)) {
                $options['removeMetadata'][$key] = 'True';
            }
        }

        $response = $this->execute($this->api->postContainer(), $options);
        $this->metadata = $this->parseMetadata($response);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata(): array
    {
        $response = $this->executeWithState($this->api->headContainer());

        return $this->parseMetadata($response);
    }
}
