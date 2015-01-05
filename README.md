LUYA INSTALLATION
=================

1.
---
create a new composer.json

```
{
    "minimum-stability": "dev",
    "require": {
        "php": ">=5.4.0",
        "yiisoft/yii2": "2.0.*",
        "zephir/luya" : "*",
        "zephir/luya-module-cms" : "*",
        "zephir/luya-module-cmsadmin" : "*",
        "zephir/luya-module-admin" : "*"
    },
    "config": {
        "process-timeout": 1800
    }
}
```

2.

```
composer global require "fxp/composer-asset-plugin:1.0.0-beta4"
```

3.
---

```
composer install
```

4.
---

Directory
.
├── application
│   ├── assets
│   └── index.php
├── composer.json
├── config
│   └── local.php

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
``