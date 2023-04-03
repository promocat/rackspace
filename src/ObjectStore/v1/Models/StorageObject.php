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

    public function getUrl(): string
    {
        return $this->getContainer()->getUrl($this->name);
    }

    public function getTemporaryUrl(int $expires, string $method = 'GET')
    {
        $method = strtoupper($method);
        $expiry = time() + (int)$expires;
        if ($method !== 'GET' && $method !== 'PUT') { // check for proper method
            throw new \Exception(sprintf('Bad method [%s] for TempUrl; only GET or PUT supported', $method));
        }
        $account = $this->getService()->getAccount();
        $account->retrieve();
        if (empty($account->tempUrl)) {
            throw new Exceptions\ObjectError('Cannot produce temporary URL without an account secret.');
        }
        $urlPath = urldecode($this->getHttpBaseUrl()->getPath() . $this->getContainer()->name . '/' . $this->name);
        $body = sprintf("%s\n%d\n%s", $method, $expiry, $urlPath);
        $hash = hash_hmac('sha256', $body, $account->tempUrl);

        return sprintf('%s?temp_url_sig=%s&temp_url_expires=%d', $this->getUrl(), $hash, $expiry);
    }
}
