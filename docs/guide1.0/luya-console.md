Console commands
================

To execute a console command open your Terminal and go into the base directory of your *LUYA* project. The base diretory is where vendor, public_html, runtime, etc. folders are located, for instance when you run the [luya-kickstarter](install.md) its in `luya-kickstarter`.

```sh
./vendor/bin/luya <command>
```

> Under windows you can run commands via the composer file `composer exec luya <command>`

Where *command* is one of the following commands below:

### Available commands

|Befehl            |Optionen                      |Beispiel                  |Beschreibung
| --------         | ---------------              | ---------                 | ---------
|migrate           |-                             |`migrate`                 |Execute all migrations from all modules, updates your database if any.
|migrate/create    |$tableName [, $moduleName ]   |`migrate/create mymigration1 modulename` |Create new migration file named `mymigration1` in the module `modulename`.
|setup             |-                             |`setup`              |Execute the *LUYA* Setup will create a user, group and base table informations.
|setup/user         |-                            |`setup/user`         |Create a new user for the *LUYA* Admin from command line.
|import            |-                             |`import`             |Updates permission, import cms blocks, updates cms layouts, updates image filters. Create your custom [importer](app-module.md#import-method)
|health            |-                             |`health`             |Tests all basic directory if they are writeable and existing.
|health/mailer     |-                             |`health/mailer`      |Check if you mailer component is working and can send mails.
|crud/create       |-                             |`crud/create`        |Create new [NgRest Crud](app-admin-module-ngrest.md) with a wizzard.
|module/create     |-                             |`module/create`      |Create new [Frontend/Admin Module](app-module.md) with a wizzard.
|command           |$moduleName, $route           |`command teammodule controller/action` |Execute your custom command (see how-to below)s.
|block/create		|-								|`block/create`	|Create new [Inhalts Blöcken](app-blocks.md) with a wizzard.
|storage/cleanup    |-								|`storage/cleanup`	|Cleanup not existing files compare file system and database.


Create your own command
------------------------
You can always create your custom command. Custom commands are stored within a module in the folder `commands`. The main differenc is that commands can only be execute from the console command and does not have view files to render, an example command. We assume you have moulde *yourmodule* with a contorller *NotifyController* with two actions *actionIndex* and *actionBar*:


```php
<?php

namespace yourmodule\commands;

class NotifyController extends \luya\console\Command
{
    public function actionIndex()
    {
    	return $this->outputSuccess('action successfully done');
    }

	public function actionBar()
	{
		return $this->ouputError('Something failed inside this action');
	}
}
```

> Always use `ouputError($message)` or `outputSuccess($message)` to return the status of the execution inside of the command, depneding on this output we can handle PHPUnit test easy and return colorized outputs.

To run the `actionIndex()` from the above mentioned `NotfyController` controller in the `yourmodule` module:

```sh
./vendor/bin/luya command yourmodule notify
```

to execute the `actionBar()` we have to change the route for the noify controller:

```sh
./vendor/bin/luya command yourmodule notify/bar
```

