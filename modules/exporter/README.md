LUYA MODEL EXPORTER
===========

> We recommend to use the LUYA Content Proxy instead of the Exporter Module!

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)

The exporter module allowss you to easily download the full database and storage data from a project for a local import and thus, to setup a state of a website at a given time.

### Installation

Add the exporter module to your composer.json:

```
"luyadev/luya-module-exporter" : "1.0.0-RC3",
```

Set up you your application configuration as follows :

```
'modules' => [
	// ...
	'exporter' => [
	    'class' => 'luya\exporter\Module',
        'downloadPassword' => 'EnterYourSecureRandomToken',
	],
]
```

And finally run the `./vendor/bin/luya migrate` and `./vendor/bin/luya import` commands.

### Using the exporter module
Now you can install a cronjob or run the command when doing deployment to prepare the download:

```sh
./vendor/bin/luya exporter/export
```

In order to download the above created files, just go into:

https://example.com/exporter?p=EnterYourSecureRandomToken and your zip will be downloaded.

> Attention! HTTP sniffers can read your plain token.

## Importing from a remote host

To import a database from a remote host, you can use this command:

```sh
./vendor/bin/luya exporter/database/remote-replace-local "mysql:host=localhost;dbname=REMOTE_DB_NAME" "USERNAME" "PASSWORD"
```

> Attention! This command will drop all tables in your current database and replace them with the remote export.

To use this in a context where you aren't able to process user inputs (chained remote batch processing like in a deployer task) you can disable the security confirmation by adding the parameter `--interactive=0`. Obviously, this should be used with extreme caution to prevent any unwanted data losses. 

> For your safety there will be an automatically created database backup of the local db. The backup can be found in the local temporary system directory - the file name resembles like this: `uniqid() . '-BACKUP-'.time()`

#### Using exporter as a deployer task

When using the LUYA deployer you may want to add the remote replace local command as a task and execute them when deploying the prep environment, here an example of what this could look like, you will find more information in the luya deployer docs:

```php
task('deploy:importProdDb', function() {
    cd('{{release_path}}');
    run('./vendor/bin/luya exporter/database/remote-replace-local "mysql:host=localhost;dbname=prod_database" "USER" "PASSWORD" --interactive=0');
})->onlyOn('prep');

after('deploy:luya', 'deploy:importProdDb');
```
