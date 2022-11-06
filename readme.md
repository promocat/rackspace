Rackspace ddapter for openstack/opencloud
================================


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist promocat/rackspace "*"
```

or add

```
"promocat/rackspace": "*"
```

to the require section of your `composer.json` file.

Usage
------------

```
new Rackspace(Rackspace::US_IDENTITY_ENDPOINT, [
    'username' => {username},
    'apiKey' => {apiKey},
]);
```
