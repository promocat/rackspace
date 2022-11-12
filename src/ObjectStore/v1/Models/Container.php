<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1\Models;

use OpenStack\Common\Resource\ResourceInterface;

class Container extends \OpenStack\ObjectStore\v1\Models\Container
{
    public function model(string $class, $data = null): ResourceInterface
    {
        if ($class === \OpenStack\ObjectStore\v1\Models\StorageObject::class) {
            $class = StorageObject::class;
        }

        return parent::model($class, $data); // TODO: Change the autogenerated stub
    }
}