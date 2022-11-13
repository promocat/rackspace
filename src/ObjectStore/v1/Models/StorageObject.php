<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1\Models;

class StorageObject extends \OpenStack\ObjectStore\v1\Models\StorageObject implements HasInitializedService
{
    use InitializedServiceTrait;

    private Container $_container;

    public function newInstance(): self
    {
        return parent::newInstance()
                     ->setContainer($this->_container)
                     ->setService($this->getService());
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
