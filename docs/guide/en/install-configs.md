Configurations
===========

LUYA includes, since `1.0.0-beta6`, several configuration files.  These configuration files are used to configure the project for several environments.
Below are all these configs and environments explained.

## Overview

![configs-graphic](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/configs-luya.jpg "Konfiguration LUYA")

## server.php
The `server.php` file returns the currently used config. It's used to change the config on different environment.
This file is ignored by GIT. If you create a new project, an example file called `server.php.dist` will be provided (See [Install](install.md)).

## localdb.php
This file contains all informations that are not meant to be shared between developers. For example the database configuration.  
This file is ignored by GIT. If you create a new project, an example file called `localdb.php.dist` will be provided (See [Install](install.md)).

## local.php
This file is used to share all configs that can be shared. It provides all necessary configs that are not in `localdb.php`.

## dev.php
The `dev.php` file should be used for environments that are online and for **development**. It can be used to show a preview to the agency / the designer but not the customer.

## prep.php
This file contains the configs for the **preproduction** environment. This environment can be used to show the website to the customer and add the content to go live.

## prod.php
And finally the config for the **production** environment. It's used to configure the site for the live environment.