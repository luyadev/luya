# Cloud & Docker 

LUYA has been proofenly used in different cloud environments using Docker and f.e. Kubernetes. This ensures your application runs in a stateless context, which means that your application does not store any informations inside the webserver itself. This makes it possible to scale LUYA into an infinite number of websites (PODs) where the load balancer can randomly send traffic to and the user won't notce anything, but actually jumping between webserver. This section explains how you have to configure LUYA in order to achieve this behavior.

## Overview

[![](https://mermaid.ink/img/eyJjb2RlIjoiZ3JhcGggVERcbiAgICBBW1VzZXIgdmlzaXRzIHlvdXIgV2Vic2VpdGVdXG4gICAgQSAtLT4gQntMb2FkIEJhbGFuY2VyfVxuICAgIEIgLS0-IERbTFVZQSBQT0QgIzFdXG4gICAgQiAtLT4gRVtMVVlBIFBPRCAjMl1cbiAgICBCIC0tPiBGW0xVWUEgUE9EICMzXVxuICAgIEQgLS0-IEdbRGF0YWJhc2VdXG4gICAgRSAtLT4gR1xuICAgIEYgLS0-IEdcbiAgICBEIC0tPiBIW0NhY2hpbmddXG4gICAgRSAtLT4gSFxuICAgIEYgLS0-IEhcbiAgICBEIC0tPiBJW1MzIFN0b3JhZ2VdXG4gICAgRSAtLT4gSVxuICAgIEYgLS0-IElcbiAgICAgICAgICAgICIsIm1lcm1haWQiOnt9LCJ1cGRhdGVFZGl0b3IiOmZhbHNlfQ)](https://mermaid-js.github.io/mermaid-live-editor/#/edit/eyJjb2RlIjoiZ3JhcGggVERcbiAgICBBW1VzZXIgdmlzaXRzIHlvdXIgV2Vic2VpdGVdXG4gICAgQSAtLT4gQntMb2FkIEJhbGFuY2VyfVxuICAgIEIgLS0-IERbTFVZQSBQT0QgIzFdXG4gICAgQiAtLT4gRVtMVVlBIFBPRCAjMl1cbiAgICBCIC0tPiBGW0xVWUEgUE9EICMzXVxuICAgIEQgLS0-IEdbRGF0YWJhc2VdXG4gICAgRSAtLT4gR1xuICAgIEYgLS0-IEdcbiAgICBEIC0tPiBIW0NhY2hpbmddXG4gICAgRSAtLT4gSFxuICAgIEYgLS0-IEhcbiAgICBEIC0tPiBJW1MzIFN0b3JhZ2VdXG4gICAgRSAtLT4gSVxuICAgIEYgLS0-IElcbiAgICAgICAgICAgICIsIm1lcm1haWQiOnt9LCJ1cGRhdGVFZGl0b3IiOmZhbHNlfQ)

This chart illustrates what is required to make your Webserver stateless:

1. a Database
2. Caching Server (f.e. Memcached)
3. S3 compataible Storage (For file uploads, assets, etc.) working as a CDN

> There different solutions you can use, for example its not required to have a shared caching system, but its strongly required as a single request can warm a cache state for all webservers!

## Dockerize your Application

First you need to Dockerize your LUYA application. There are maybe multiple docker images available, but for **production** we currently recommend to use https://gitlab.com/zephir.ch/foss/luya-docker. Create a `Dockerfile` which could look like this:

```
FROM registry.gitlab.com/zephir.ch/foss/luya-docker:1

## Replace the default server name `luya` with your own server name
RUN sed -i 's/server_name luya;/server_name MY_SUPER_WEBSITE.COM;/g' /etc/nginx/conf.d/default.conf

COPY . /var/www/html

RUN mkdir -p /var/www/html/public_html/assets
RUN mkdir -p /var/www/html/runtime

RUN chmod 777 /var/www/html/public_html/assets
RUN chmod 777 /var/www/html/runtime
```

By default this will load the {{luya\Config}} with `ENV_PROD`, you can adjust this by chaning the ENV variable `LUYA_CONFIG_ENV` on run or build time.

## Configure your Application

Ensure [LUYA AWS](https://github.com/luyadev/luya-aws) is installed, so you can store files and assets into your s3 compatible storage system. 

#### Storage Component

```php
$config->component('storage', [
    'class' => 'luya\aws\S3FileSystem',
    'bucket' => 'BUCKET_NAME',
    'key' => 'KEY',
    'secret' => 'SECRET',
    'region' => 'eu-central-1',
]);
```

#### Cache Component

```php
$config->component('cache', [
    'class' => 'yii\caching\MemCache',
    'useMemcached' => true,
    'servers' => [
        [
            'host' => 'MEMCACHEDSERVER',
            'port' => '11211',
            'weight' => 100,
        ],
    ],
]);
```

#### Session Component

When you have connection to a database, use:

```php
$config->component('session', [
    'class' => 'yii\web\DbSession',
    'sessionTable' => 'admin_session',
]);
```

otherwise use the session cache

```php
$config->component('session', [
    'class' => 'yii\web\CacheSession',
]);
```

#### Asset Manager Component

When you have LUYA AWS S3 Storage enabled, you can switch the asset manager to use that bucket. LUYA will upload your assets to that server, so the resources file are served from a CDN:

```php
$config->component('assetManager', [
    'class' => 'luya\aws\AssetManager',
    'forceCopy' => false,
    'appendTimestamp' => true,
]);
```

Without bucket, you can at least configured the asset manager to not create unique timestamp, this allows you to have multiple webservers at the same time:

```php
$config->component('assetManager', [
    'appendTimestamp' => true,
    'hashCallback' => function ($path) {
        return hash('md4', $path);
    }  
]);

#### Request Component

If the urls do not contain https schema, this is because [$isSecureConnection](https://www.yiiframework.com/doc/api/2.0/yii-web-request#getIsSecureConnection()-detail) will return false, therefor you can define the secure headers or disable them as followed:

```php
$config->webComponent('request', [
    'secureHeaders' => [],
]);
```
