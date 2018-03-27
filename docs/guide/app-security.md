# Security

A few tricks to increase the security of your application in production environment:

## Webserver & Files

Make sure to that your webserver points to the `public_html` directory otherwise some sensitive data containing files could be exposed to public. Specially for yml or env files. So make sure not to commit the `.env` file from docker which contains your access token!

## DNS Wildcard

The {{luya\web\Composition::$allowedHosts}} property inside the composition component in order to prevent dns wildcard hijacking.

```php
'composition' => [
    'allowedHosts' => [
        'prep.testserver.com', '*.productionserver.com',
    ]
]
```

## Secure connection

Iin production env should https always be enabled in order to prevent man in the middle attacks. This can be enabled in your htaccess or in webserver configuration, but you can also, as a fallback, enable this setting in order to ensure secure connection on application level.

```php
return [
    'id' => 'myapp',
    // ...
    '$ensureSecureConnection' => true,
    // ...
]
```

## Deployemnt

We recommend to use LUYA Deployer in order to deploy your website, therefore you have to provide credentials to your VCS and Webserver, in order to increase security you should use a `PEM` file to make the webserver connection. By default the luya deployer will remove sensitive files like README, deployer.php, composer.json, composer.lock after deployment.