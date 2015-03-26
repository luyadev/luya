CONSOLE
=======

How to exec console commands?
-----------------------------

Open your terminal window (mac or linux) and navigate into the public_html diretory. All the terminal commands for your project will go trough your index.php file, like the web requests as well.

```
cd /var/www/_YOUR_PROJECT_/public_Html
```

now you can execute all the console commands described below.


presql
--------

create a new migration script
```
php index.php presql/create TABLE_NAME MODULE_NAME
```

execute all migrations for all modules

```
php index.php presql
```


exec
-----

***setup***

if you are creating a new project you can use the setup proccess to prefill your database (after pressql (migration) command).

```
php index.php exec/setup
```

the above command will ask for an email adress and password.

***import***

The import command will call the import() method inside of your Module class.

```
php index.php exec/import
```

