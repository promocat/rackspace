<?php

namespace PromoCat\Identity;

use OpenStack\Identity\v2\Api as OpenStackApi;

class Api extends OpenStackApi
{
    public function postToken(): array
    {
        return [
            'method' => 'POST',
            'path' => 'tokens',
            'params' => [
                'username' => [
                    'type' => 'string',
                    'required' => true,
                    'location' => 'json',
                    'path' => 'auth.RAX-KSKEY:apiKeyCredentials',
                ],
                'apiKey' => [
                    'type' => 'string',
                    'required' => true,
                    'location' => 'json',
                    'path' => 'auth.RAX-KSKEY:apiKeyCredentials',
                ],
            ],
        ];
    }
}
