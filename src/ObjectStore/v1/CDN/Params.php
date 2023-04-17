<?php

declare(strict_types=1);

namespace PromoCat\Rackspace\ObjectStore\v1\CDN;

use OpenStack\Common\Api\AbstractParams;

class Params extends AbstractParams
{
    public function containerName(): array
    {
        return [
            'location' => self::URL,
            'required' => true,
            'description' => <<<EOT
The unique name for the container. The container name must be from 1 to 256 characters long and can start with any
character and contain any pattern. Character set must be UTF-8. The container name cannot contain a slash (/) character
because this character delimits the container and object name. For example, /account/container/object.
EOT,
        ];
    }

    public function cdnEnabled(): array
    {
        return [
            'location' => self::HEADER,
            'required' => true,
            'type' => self::STRING_TYPE,
            'sentAs' => 'X-CDN-Enabled',
            'description' => <<<EOT
If set to true, the container will be CDN-enabled. Before a container can be CDN-enabled, it must exist in the storage system.
EOT,
        ];
    }

    public function ttl(): array
    {
        return [
            'location' => self::HEADER,
            'type' => self::INT_TYPE,
            'sentAs' => 'X-TTL',
            'description' => <<<EOT
Any CDN-accessed objects are cached in the CDN for the specified amount of time called the TTL. 
The default TTL value is 259200 seconds, or 72 hours. 
Each time the object is accessed after the TTL expires, the CDN refetches and caches the object for the TTL period.
EOT,
        ];
    }
}
