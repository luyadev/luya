The Luya Project
=================

If you want to install luya on your composer, please use the [Luya Kickstarter](https://github.com/zephir/luya-kickstarter). Otherwise you can create a project as descripbed below:

Installation
--------------

Go into your project folder (could be an github clone) and add a composer.json, if you have not yet installed composer please follow the [Composer Installation Guide](https://getcomposer.org/doc/00-intro.md).

composer.json File:
```
{
    "minimum-stability": "dev",
    "require": {
        "zephir/luya" : "*",
        "zephir/luya-module-cms" : "*",
        "zephir/luya-module-cmsadmin" : "*",
        "zephir/luya-module-admin" : "*"
    }
}
```
Add the global requirement command for composer asset plugins which are required as described from the Yii2 project.

```
composer global require "fxp/composer-asset-plugin:1.0.0-beta4"
```

Install the packages defined in your composer.json

```
composer install
```

Create you application structur.

Directory  
```
.  
├── application  
│   ├── assets  
│   └── index.php  
├── composer.json  
├── config  
│   └── local.php  
```

Go to ***http://localhost/PROJECT/application*** - you'r done!

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

change the php version to your current active php version. To verify and test this informations use:
```
which php
php -i
```