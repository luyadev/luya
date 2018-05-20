# Console commands

To execute a console command open your terminal and change into the base directory of your *LUYA* project. 
The base directory is where folders like vendor, public_html, runtime are located, e. g. when you run the [luya-kickstarter](install.md) its in `luya-kickstarter`.

```sh
./vendor/bin/luya <command>
```

> On Windows systems you can run commands from the public_html folder and run: `php index.php <command>`

Where *command* is one of the following commands below:

## Standard built in commands

Global LUYA commands:

|Command|Description
|--------|---------
|`import`|Updates permission, cms blocks, cms layouts, image filters. Import is a one of the main concepts of LUYA. Its saving your project data into the database. This way you can track your files within VCS (Git, SVN) and import them. [Create Import Commmand](app-module.md#import-method).
|`migrate`|Execute all migrations from all modules, updates your database if any. The main difference to the Yii migrate command is its going to collect all migrations from all modules.
|`migrate/create migration1 modulename`|Create new migration file named `mymigration1` in the module `modulename`: `migrate/create mymigration1 modulename`.
|`health`|Tests all basic directory if they are writable and existing.
|`health/mailer`|Check if you mailer component is working and can send mails.
|`module/create`|Create new [frontend/admin module](app-module.md) with a wizzard.
|`module/controller/action`|All commands stored in the folder `commands` can be run by default routing.

Admin UI commands:

|Command|Description
|---    |---
|`admin/setup`|Execute the *LUYA* Setup will create a user, group and base table informations.
|`admin/setup/user`|Create a new user for the *LUYA* Admin UI from command line.
|`admin/filter`|Generate a [Filter](app-filters.md) Class.
|`admin/proxy`|Start the [content sync](concept-depandsync) process.
|`admin/proxy/clear`|Flush the configuration setup for the content sync process.
|`admin/storage/cleanup`|Cleanup not existing files compare file system and database.
|`admin/storage/cleanup-image-table`|Find if duplications are available in the image table (same filter and file id). If confirmed it will remove all duplications except of one, the first one created.
|`admin/storage/process-thumbnails`|Create all thumbnails for filemanager preview. Otherwise they are created on request load.
|`admin/active-window/create`|Generate a [new Active Window](ngrest-activewindow.md) class file based on your configuration.
|`admin/crud/create`|Create new [NgRest CRUD](ngrest-concept.md) with a wizzard.
|`admin/crud/model`|Generates only the [NgRestModel](ngrest-model.md). Usage `./vendor/bin/luya admin/crud/model "app\models\Customer"` 

CMS module commands:

|Command|Description 
|---    |---
|`cms/block/create`|Create new [CMS content blocks](app-blocks.md) with a wizzard.


## Create your own command

You can create your own custom commands. Custom commands are stored as actions of controllers in the `commands` directory of a module. Commands can only be executed from the console and do not have view files to render.

Let's assume you have a module `yourmodule` with a controller `NotifyController` that includes two actions `actionIndex` and `actionBar` (stored in the file `NotifyController.php` within the `commands` directory of your module):


```php
<?php

namespace yourmodule\commands;

class NotifyController extends \luya\console\Command
{
    public function actionIndex()
    {
        return $this->outputSuccess('Action successfully done');
    }

    public function actionBar()
    {
        return $this->outputError('Something failed inside this action');
    }
}
```

> Always use `ouputError($message)` or `outputSuccess($message)` to return the status of the execution inside of the command, depending on this output we can handle PHPUnit test easy and return colorized outputs.

To run the `actionIndex()` from the above mentioned `NotfyController` controller in the `yourmodule` module:

```sh
./vendor/bin/luya yourmodule/notify
```

to execute the `actionBar()` we have to change the route for the notify controller:

```sh
./vendor/bin/luya yourmodule/notify/bar
```

If you want to create a command without a module you can just add the the Command controller into the `commands` folder of your application and add the controller to your `controllerMap` of your configuration like the example below:

```php
'controllerMap' => [
    'sync' => 'app\commands\SyncController',
],
```

Now you could run the sync command like all other commands with `./vendor/bin/luya sync`

### Views and UrlManger

Its very often case where you like to render a view and send a mail inside a console command, like batch processing some data (newsletter for example). Therefore your views use the {{luya\helpers\Url}} class in order to generate urls.

As the console command does not know your web server URL and there is no parameter of your web server url, therefore LUYA has a special configuration property called {{luya\traits\ApplicationTrait::$consoleHostInfo}}.

This value will be used when defined as baseUrl for the urlManager.

```php
'consoleHostInfo' => 'https://luya.io',
```
