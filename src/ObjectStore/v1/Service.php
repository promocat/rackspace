<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1;

use OpenStack\Common\Resource\ResourceInterface;
use OpenStack\Common\Service\Builder;
use PromoCat\Rackspace\ObjectStore\v1\CDN\Service as CdnService;
use PromoCat\Rackspace\ObjectStore\v1\Models\Container;
use PromoCat\Rackspace\ObjectStore\v1\Models\HasInitializedService;

/**
 * @method Container getContainer(string $name = null)
 * @method Container createContainer(array $data)
 * @method \Generator|Container[] listContainers(array $options = [], callable $mapFn = null)
 */
class Service extends \OpenStack\ObjectStore\v1\Service
{
    private Builder $builder;
    private array $cdnOptions = [];

    private CdnService $cdnService;

    public function model(string $class, $data = null): ResourceInterface
    {
        if ($class === \OpenStack\ObjectStore\v1\Models\Container::class) {
            $class = Container::class;
        }

        $model = parent::model($class, $data);
        if ($model instanceof HasInitializedService) {
            $model->setService($this);
        }

        return $model;
    }

    public function getCdnService(): CdnService
    {
        if (!isset($this->cdnService)) {
            if (!isset($this->builder)) {
                throw new \Exception('The service builder should be set to create the requested CDN Service.');
            }
            $this->cdnService = $this->builder->createService('ObjectStore\\v1\\CDN', $this->cdnOptions);
        }

        return $this->cdnService;
    }

    public function setCdnService(CdnService $cdnService): self
    {
        $this->cdnService = $cdnService;

        return $this;
    }

    public function setServiceBuilder(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function setCdnOptions(array $cdnOptions = [])
    {
        $this->cdnOptions = array_merge([
            'catalogName' => 'cloudFilesCDN',
            'catalogType' => 'rax:object-cdn',
        ], $cdnOptions);
    }
}
