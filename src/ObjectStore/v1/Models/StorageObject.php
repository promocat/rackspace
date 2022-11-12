<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1\Models;

use GuzzleHttp\Psr7\Uri;
use PromoCat\Rackspace\Constants\UrlType;

class StorageObject extends \OpenStack\ObjectStore\v1\Models\StorageObject
{
    private Container $_container;

    public function newInstance(): self
    {
        return parent::newInstance()->setContainer($this->_container);
    }

    public function setContainer(Container $container): self
    {
        $this->_container = $container;

        return $this;
    }

    public function getContainer(): Container
    {
        return $this->_container;
    }
}
