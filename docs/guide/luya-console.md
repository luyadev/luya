# Console commands

To execute a console command open your Terminal and go into the base directory of your *LUYA* project. The base diretory is where vendor, public_html, runtime, etc. folders are located, for instance when you run the [luya-kickstarter](install.md) its in `luya-kickstarter`.

```sh
./vendor/bin/luya <command>
```

> On Windows systems you can run commands by going into the public_html folder an run: `php index.php <command>`

Where *command* is one of the following commands below:

### Available commands

Global LUYA commands:

|Command|Description
|--------|---------
|`import`|Updates permission, import cms blocks, updates cms layouts, updates image filters. Create your custom [importer](app-module.md#import-method) to run jobs while importing. Import is base of the main concepts of LUYA. It tryes to synchronize your project data into the database. This way you can track your files within version control systems and you don't have to copy database between enviroments.
|`migrate`|Execute all migrations from all modules, updates your database if any. The main difference to the Yii migrate command is its going to collect all migrations from all modules.
|`migrate/create migration1 modulename`|Create new migration file named `mymigration1` in the module `modulename`: `migrate/create mymigration1 modulename`.
|`health`|Tests all basic directory if they are writeable and existing.
|`health/mailer`|Check if you mailer component is working and can send mails.
|`module/create`|Create new [frontend/admin module](app-module.md) with a wizzard.
|`module/controller/action`|All comands stored in the folder `commands` can be run by default routing.

Admin Module commands:

|Command|Description
|---    |---
|`admin/setup`|Execute the *LUYA* Setup will create a user, group and base table informations.
|`admin/setup/user`|Create a new user for the *LUYA* Admin from command line.
|`admin/filter`|Generate a [Filter](app-filters.md) Class.
|`admin/proxy`|Start the [content sync](concept-depandsync) process.
|`admin/proxy/clear`|Flush the configuration setup for the content sync process.
|`admin/storage/cleanup`|Cleanup not existing files compare file system and database.
|`admin/storage/cleanup-image-table`|Find if dupliations are available in the image table (same filter and file id). If confirmed it will remove all duplications except of one, the first one created.
|`admin/storage/process-thumbnails`|Create all thumbnails for filemanager preview. Otherwhise they are created on request load.
|`admin/active-window/create`|Generate a [new Active Window](ngrest-activewindow.md) class file based on your configuration.
|`admin/crud/create`|Create new [NgRest CRUD](ngrest-concept.md) with a wizzard.
|`admin/crud/model`|Generates only the [NgRestModel](ngrest-model.md). Usage `./vendor/bin/luya admin/crud/model "app\models\Customer"` 

CMS Module commands:

|Command|Description
|---    |---
|`cms/block/create`|Create new [CMS content blocks](app-blocks.md) with a wizzard.


## Create your own command

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
./vendor/bin/luya yourmodule/notify
```

to execute the `actionBar()` we have to change the route for the noify controller:

```sh
./vendor/bin/luya yourmodule/notify/bar
```

If you want to create a command without a module you can just add the the Command controller into the `commands` folder of your application and the add the the controller to your `controllerMap` of your configuration like the example below:

```php
'controllerMap' => [
    'sync' => 'app\commands\SyncController',
],
```

Now you could run the sync command like all other commands with `./vendor/bin/luya sync`.   
