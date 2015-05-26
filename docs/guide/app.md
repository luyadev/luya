Installation
================

```
composer global require "fxp/composer-asset-plugin:~1.0"
```

Creates a folder with the repo name (luya-kickstarter)

```
composer create-project --prefer-dist zephir/luya-kickstarter:dev-master 
```

You should always remove the VCS repository from the created project.

```
Do you want to remove the existing VCS (.git, .svn..) history? [Y,n]? 
```

***CONFIGS***

Rename the configuration files inside of the configs/ folder from server.php.dist to server.php and load your project specific confiuration files. Checkout the different dist config files to build your own custom config.

***DATABASE***

Go into your terminal and navigate to the index.php file which is located in the public_html folder and execute the following command the run all your migration scripts

```
cd /var/www/_YOUR_PROJECT_/public_html
php index.php presql/up
```

***SETUP***

The setup proccess will ask you for an email and password to store your personal login inside the database (of course the password will be encrypted).

```
cd /var/www/_YOUR_PROJECT_/public_html
php index.php exec/setup
```

You can now log in into your administration interface http://localhost/_YOUR_PROJECT_/admin.

composer.json
--------------

do not forget to changed the composer.json for your prefed needs. (removed the luya-kickstarter name, add your packages).


Installtion on MAC OSX with MAMP
---
Use a different DSN in the Config
```
'dsn' => 'mysql:host=localhost;dbname=luyaweb;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock',
```

Create a .bash_profile file in your home folder (cd ~) with following content
```
export PATH=/Applications/MAMP/bin/php/php5.6.2/bin:$PATH
```
***Attention:*** If you've [ZSH](https://github.com/robbyrussell/oh-my-zsh) installed, add the above "export" line to the ***end*** of the ***.zshrc*** file in your home directory (~/.zshrc).

change the php version to your current active php version. To verify and test this informations use:
```
which php
php -i
```

Contribution
--------------

Check the [start collaboration Guide](docs/guide/start-collaboration.md) if you want to contribute to the luya project.

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

If you are using the cms as default module. you should register your assets files directly into the cms module configuration like this:

```php

'cms' => [
    'class' => 'cms\Module',
    'assets' => [
        '\\app\\assets\\Project'
    ]
]

```