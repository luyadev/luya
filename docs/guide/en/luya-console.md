CONSOLE
=======

How to exec console commands?
-----------------------------

Open your terminal window (mac or linux) and navigate into the project diretory. All the terminal commands for your project will go trough a bin file in your vendor directory, called *luya*.

```
cd /var/www/project_directory
```

now you can execute all the console commands described below.


migration
--------
(former alpha-10 *presql*)
***create***

create a new migration script
```
./vendor/bin/luya migrate/create TABLE_NAME MODULE_NAME
```

***up***

execute all migrations for all modules

```
./vendor/bin/luya migrate
```


exec
-----

***setup***

if you are creating a new project you can use the setup proccess to prefill your database (after pressql (migration) command).

```
./vendor/bin/luya setup
```

the above command will ask for an email adress and password.

***import***

The import command will call the import() method inside of your Module class.

```
./vendor/bin/luya import
```
A uscase for the abovce example are project(app) layouts and blocks. The importer detect layouts and blocks defined in the project and inserts those into your local database.

crud
----
create ngrest crud components:
```
./vendor/bin/luya crud/create
```

module
------
create admin/frontend module:
```
./vendor/bin/luya module/create
```

Create your console command
---------------------------
To add a module console command just create a file inside `@module/commands` like below

```
<?php

namespace yourmodule\commands;

/**
 * ./vendor/bin/luya command yourmodule notify
 */
class NotifyController extends \luya\console\Command
{
    public function actionIndex()
    {
        return 'hello world!';
    }
    
    public function actionBar()
    {
    	return 'foo';
    }
}
```

execute the command in your terminal:
```
./vendor/bin/luya command yourmodule notify
```

to execute the bar action you have the execute the command like this:
```
./vendor/bin/luya command yourmodule notify/bar
```