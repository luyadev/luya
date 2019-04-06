# Environments


LUYA is shipped with several configuration files. These config files are in charge to configure the project for different stages or environments.

Below, all these configs and environments explained:

## Overview

![configs-graphic](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/configs-luya.jpg "LUYA envs config")

## env.php
The `env.php` file returns the currently used config, so this file is used to change the config on different environment.
This file is ignored by GitHub by default. 
If a new project is created an example file named `env.php.dist` will be provided (see [Install](install.md)).

## env-local-db.php
This file contains all informations which are not planed to be shared between developers, e.g. the database configuration.  
This file is ignored by Github by default as well. 
If a new project is created an example file named `env-local-db.php.dist` will be provided (see [Install](install.md)).

## env-local.php
This file is used to store all configs for developers which can be shared. All necessary configs which are not in `env-local-db.php` are provided by this file.

## env-dev.php
The `env-dev.php` file should be used for environments that are online but are still under **development**. It can be used to show a preview to the agencies and/or designes but should not be used for customers.

## env-prep.php
The `env-prep.php` file contains the configs for the **preproduction** environment. This environment can be used to show the website to the customer and add the content before the go live.

## env-prod.php
And finally the `env-prod.php` for the **production** environment. It is used to configure the site for the live environment.
