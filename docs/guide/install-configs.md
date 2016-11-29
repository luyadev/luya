Configurations
===========

LUYA includes, several configuration files.  These configuration files are used to configure the project for several environments.
Below are all these configs and environments explained.

## Overview

![configs-graphic](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/configs-luya.jpg "LUYA Envs config")

## env.php
The `env.php` file returns the currently used config. It's used to change the config on different environment.
This file is ignored by GIT. If you create a new project, an example file called `env.php.dist` will be provided (See [Install](install.md)).

## env-local-db.php
This file contains all informations that are not meant to be shared between developers. For example the database configuration.  
This file is ignored by GIT. If you create a new project, an example file called `env-local-db.php.dist` will be provided (See [Install](install.md)).

## env-local.php
This file is used to share all configs that can be shared. It provides all necessary configs that are not in `env-local-db.php`.

## env-dev.php
The `env-dev.php` file should be used for environments that are online and for **development**. It can be used to show a preview to the agency / the designer but not the customer.

## env-prep.php
This file contains the configs for the **preproduction** environment. This environment can be used to show the website to the customer and add the content to go live.

## env-prod.php
And finally the config for the **production** environment. It's used to configure the site for the live environment.