<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1\Models;

use OpenStack\Common\Resource\ResourceInterface;
use PromoCat\Rackspace\ObjectStore\v1\Api;

/**
 * @property Api $api
 */
class Container extends \OpenStack\ObjectStore\v1\Models\Container
{
    private $cdn;

    /**
     * {@inheritdoc}
     */
    public function model(string $class, $data = null): ResourceInterface
    {
        if ($class === \OpenStack\ObjectStore\v1\Models\StorageObject::class) {
            $class = StorageObject::class;
        }

        $model = parent::model($class, $data);
        if ($model instanceof StorageObject) {
            $model->setContainer($this);
        }

        return $model;
    }
}
