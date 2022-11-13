<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1\Models;

use OpenStack\Common\Service\ServiceInterface;

trait InitializedServiceTrait
{
    private ServiceInterface $_service;

    public function setService(ServiceInterface $service): self
    {
        $this->_service = $service;

        return $this;
    }

    public function getService(): ServiceInterface
    {
        return $this->_service;
    }
}
