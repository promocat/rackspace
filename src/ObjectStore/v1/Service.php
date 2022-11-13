<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1;

use OpenStack\Common\Resource\ResourceInterface;
use PromoCat\Rackspace\ObjectStore\v1\CDN\Service as CDNService;
use PromoCat\Rackspace\ObjectStore\v1\Models\Container;
use PromoCat\Rackspace\ObjectStore\v1\Models\HasInitializedService;

class Service extends \OpenStack\ObjectStore\v1\Service
{
    private CDNService $cdnService;

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

    public function getCdnService(): CDNService
    {
        return $this->cdnService;
    }

    public function setCdnService(CDNService $cdnService): self
    {
        $this->cdnService = $cdnService;

        return $this;
    }
}
