# Security

A few tips to increase the security of your application in a production environment:

## Webserver & Files

Make sure that your webserver points to the `public_html` directory, otherwise sensitive data contained in files might be exposed to the public. Preventing exposure is especially important with yml or env files. Therefore make sure not to commit the `.env` file from Docker, as it contains your access token!

## DNS Wildcard

Use the {{luya\web\Composition::$allowedHosts}} property inside the composition component in order to prevent DNS wildcard hijacking.

```php
'composition' => [
    'allowedHosts' => [
        'prep.testserver.com', '*.productionserver.com',
    ]
]
```

## Secure Connection

In production environments, HTTPS should always be enabled in order to prevent man-in-the-middle attacks. HTTPS can be enabled in the htaccess file or webserver configuration. To enforce HTTPS on an application level (throwing exceptions for non HTTPS calls), use the ensureSecureConnection application property.

```php
return [
    'id' => 'myapp',
    // ...
    'ensureSecureConnection' => true,
    // ...
]
```

## Secure login

We recommend to enable {{luya\admin\Module::$secureLogin}} which will send you a token by email you have to enter. As maybe your customers do not use strong passwords we recommend to enable this option. In order to use $secureLogin your mail component must be configure well in order to send emails with secure tokens.

```php
'admin' => [
    'class' => 'luya\admin\Module',
    'secureLogin' => true,
]
```

## Deployment

We recommend to use the LUYA deployer in order to deploy your website. To do so you have to provide credentials to your VCS and webserver. In order to increase security, you should use a `PEM` file to make the webserver connection. By default, the LUYA deployer will remove sensitive files like README, deployer.php, composer.json, composer.lock after deployment.
