CONSOLE
=======

How to exec console commands?
-----------------------------

Open your terminal window (mac or linux) and navigate into the public_html diretory. All the terminal commands for your project will go trough your index.php file, like the web requests as well.

```
cd /var/www/_YOUR_PROJECT_/public_Html
```

now you can execute all the console commands described below.


migration
--------
(former alpha-10 *presql*)
***create***

create a new migration script
```
php index.php migrate/create TABLE_NAME MODULE_NAME
```

***up***

execute all migrations for all modules

```
php index.php migrate
```


exec
-----

***setup***

if you are creating a new project you can use the setup proccess to prefill your database (after pressql (migration) command).

```
php index.php setup
```

the above command will ask for an email adress and password.

***import***

The import command will call the import() method inside of your Module class.

```
php index.php import
```
A uscase for the abovce example are project(app) layouts and blocks. The importer detect layouts and blocks defined in the project and inserts those into your local database.

crud
----
create ngrest crud components:
```
php index.php crud/create
```

module
------
create admin/frontend module:
```
php index.php module/create
```

Create your console command
---------------------------
To add a module console command just create a file inside `@module/commands` like below

```
<?php

namespace yourmodule\commands;

/**
 * php index.php command yourmodule notify
 */
class NotifyController extends \luya\base\Command
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
php index.php command yourmodule notify
```

to execute the bar action you have the execute the command like this:
```
php index.php command yourmodule notify/bar
```