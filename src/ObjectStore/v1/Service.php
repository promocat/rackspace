<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1;

use OpenStack\Common\Resource\ResourceInterface;
use PromoCat\Rackspace\ObjectStore\v1\Models\Container;

class Service extends \OpenStack\ObjectStore\v1\Service
{
    public function model(string $class, $data = null): ResourceInterface
    {
        if ($class === \OpenStack\ObjectStore\v1\Models\Container::class) {
            $class = Container::class;
        }

        return parent::model($class, $data);
    }
}
