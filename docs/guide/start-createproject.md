Create a new luya project
==========================

Project folder

```
.
├── public_html
│   ├── assets
│   └── css
├── assets
├── config
├── migrations
├── modules
│   └── estore
│       ├── assets
│       ├── controllers
├── runtime
└── views
    ├── cmslayouts
    ├── estore
    │   └── default
    └── layouts

```

example config

```php
$config = [
    'id' => 'luya-website',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'cms',
    'modules' => [
        'luya' => 'luya\Module',
        'admin' => 'admin\Module',
        'cms' => [
            'class' => 'cms\Module',
            'assets' => [
                '\\app\\assets\\Project'
            ]
        ],
        'cmsadmin' => 'cmsadmin\Module',
        'estore' => 'app\modules\estore\Module',
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=DATABASENAME',
            'username' => 'USERNAME',
            'password' => 'PASSWORD',
        ]
    ],
];
```

If you are using the cms as default public_html you have to register your assets files directly into the cms module configuration like this:

```php

'cms' => [
    'class' => 'cms\Module',
    'assets' => [
        '\\app\\assets\\Project'
    ]
]

```