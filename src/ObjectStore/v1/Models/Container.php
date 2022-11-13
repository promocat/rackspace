<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1\Models;

use OpenStack\Common\Resource\ResourceInterface;
use PromoCat\Rackspace\ObjectStore\v1\Api;
use PromoCat\Rackspace\ObjectStore\v1\CDN\Models\Container as CDNContainer;

/**
 * @property Api $api
 */
class Container extends \OpenStack\ObjectStore\v1\Models\Container implements HasInitializedService
{
    use InitializedServiceTrait;

    protected $aliases = [
        'count' => 'objectCount',
        'bytes' => 'bytesUsed',
    ];

    private ?CDNContainer $cdn = null;

    public function newInstance(): self
    {
        return parent::newInstance()
                     ->setService($this->getService());
    }

    /**
     * {@inheritdoc}
     */
    public function model(string $class, $data = null): ResourceInterface
    {
        if ($class === \OpenStack\ObjectStore\v1\Models\StorageObject::class) {
            $class = StorageObject::class;
        }

        $model = parent::model($class, $data);

        if ($model instanceof HasInitializedService) {
            $model->setService($this->getService());
        }

        if ($model instanceof StorageObject) {
            $model->setContainer($this);
        }

        return $model;
    }

    public function getCdn(): CDNContainer
    {
        if (!$this->isCdnEnabled()) {
            throw new \Exception('Either this container is not CDN-enabled or the CDN is not available');
        }

        return $this->cdn;
    }

    public function isCdnEnabled(): bool
    {
        if (!isset($this->cdn)) { // If CDN object is not already populated, try to populate it.
            $this->refreshCdnObject();
        }

        return ($this->cdn instanceof CDNContainer) && $this->cdn->isCdnEnabled();
    }

    protected function refreshCdnObject()
    {
        try {
            if (($cdnService = $this->getService()->getCDNService()) !== null) {
                $this->cdn = $cdnService->getContainer($this->name);
            } else {
                $this->cdn = null;
            }
        } catch (\Exception $e) {
        }
    }
}
