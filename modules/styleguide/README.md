<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# Element component styleguide

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-module-styleguide/v/stable)](https://packagist.org/packages/luyadev/luya-module-styleguide)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-module-styleguide/downloads)](https://packagist.org/packages/luyadev/luya-module-styleguide)
[![Slack Support](https://img.shields.io/badge/Slack-luyadev-yellowgreen.svg)](https://slack.luya.io/)

The basic idea behind the stylegiude is to give you the ability to ensure an advanced development cycle for functions and design of enhanced elements.

The styleguide module renders all the available {{luya\web\Element}} with example content wich let you share all the elements with other designer to make and discuss changes based on elements instead on a finished web page. 

## Installation

For the installation of modules Composer is required.

```sh
composer require luyadev/luya-module-styleguide:~1.0.0
```

### Configuration 

Configure the module in your project config, the password is protecting this page by default:

```php
return [
    // ...
    'modules' => [
        // ...
        'styleguide' => [
            'class' => 'luya\styleguide\Module',
            'password' => 'styleguide-password',
            'assetFiles' => [
                'app\assets\ResourcesAsset',
            ],
        ]
    ]
]
```


After successful configuration of the styleguide module you can access it trough the url: `yourdomain.com/styleguide`
