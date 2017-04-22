# Element Component Styleguide

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)

We have build a styleguide modules which renders all the available elements with example content, so you can share all the elements with other designer and make and discuss changes based on elements on not just on a finished web page, this gives you the ability to make more specific changes.

Add the luya style guide module to your composer json

```sh
require luyadev/luya-module-styleguide:1.0.0-RC3
```

Configure the Module in your project config, the password is protected this page by default.

```php
return [
    // ...
    'modules' => [
        // ...
        'styleguide' => [
            'class' => 'luya\styleguide\Module',
            'password' => 'myguide',
            'assetFiles' => [
                'app\assets\ResourcesAsset',
            ],
        ]
    ]
]
```

When you have successfull configure the styleguide module you can access it trough the url: `mywebsite.com/styleguide`