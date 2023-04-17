<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1\Models;

use OpenStack\Common\Service\ServiceInterface;

interface HasInitializedService
{
    public function setService(ServiceInterface $service): self;

    public function getService(): ServiceInterface;
}
