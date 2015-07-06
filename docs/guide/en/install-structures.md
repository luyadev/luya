Example Data
============

Example Project Folder Hierarchy
--------------------------------
```
.
├── public_html
│   ├── assets
│   └── css
├── assets
├── blocks
├── filters
├── configs
├── migrations
├── modules
│   ├── <APP-MODULE>
│   │   ├── assets
│   │   └── controllers
│   └── <APP-ADMIN-MODULE>
│       ├── assets
│       └── controllers
├── runtime
└── views
    ├── <APP-MODULE>
    │   └── default
    ├── cmslayouts
    └── layouts
```

Example Config
--------------

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