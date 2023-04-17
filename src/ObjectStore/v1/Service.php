<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1;

use OpenStack\Common\Resource\ResourceInterface;
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
        return $this->cdnService;
    }

    public function setCdnService(CdnService $cdnService): self
    {
        $this->cdnService = $cdnService;

        return $this;
    }
}
