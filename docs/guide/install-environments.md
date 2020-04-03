# Environments


LUYA is shipped with several configuration files. These config files are in charge to configure the project for different stages or environments.

Below, all these configs and environments explained:

## Overview

![configs-graphic](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/configs-luya.jpg "LUYA envs config")

## env.php

The `env.php` file returns the currently used config, so this file is used to change the config on different environment.
This file is ignored by GitHub by default. If a new project is created an example file named `env.php.dist` will be provided (see [Install](install.md)).

## config.php

> Since version 1.0.21 of LUYA core the {{luya\Config}} is used to generate configs.

The config.php file contains a {{luya\Config}} object, in order to defined components, modules or application level configurations for a certain environment use {{luya\Config::env()}} method:

An example for define the db component for certain environments:

 ```php
 $config->component('db', [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=prod_db',
    'username' => 'foo',
    'password' => 'bar',
])->env(Config::ENV_LOCAL);

$config->component('db', [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=prod_db',
    'username' => 'foo',
    'password' => 'bar',
])->env(Config::ENV_DEV);

$config->component('db', [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=prod_db',
    'username' => 'foo',
    'password' => 'bar',
])->env(Config::ENV_PROD);
```

The {{luya\Config}} has constants for all LUYA env types:

+ {{luya\Config::ENV_ALL}}: All environments
+ {{luya\Config::ENV_LOCAL}}: local computer (local development stage)
+ {{luya\Config::ENV_DEV}}: dev/shared server
+ {{luya\Config::ENV_PREP}}: preproduction server
+ {{luya\Config::ENV_CI}}: ci server
+ {{luya\Config::ENV_PROD}}: production
