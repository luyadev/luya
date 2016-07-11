Export Data
===========

The exporter module allows you to easy download the full database and storage data from a project for a local import. This allows you to setup a state of a website.

### Install

Add to your composer.json:

```
"luyadev/luya-module-exporter" : "1.0.0-beta5",
```

Add the module to your application config:

```
'modules' => [
	// ...
	'exporter' => [
	    'class' => 'exporter\Module',
        'downloadPassword' => 'EnterYourSecureRandomToken',
	],
]
```

### Using exporter
Now you can install a cronjob or run the command when doing deployment to prepare the download:

```sh
./vendor/bin/luya exporter/export
```

In order to download the above created files, just go onto:

https://example.com/exporter?p=EnterYourSecureRandomToken and your zip will be downloaded.

> Attention! HTTP sniffers can read your plain token.

## Using Database exporter/importer

To import a database from a remote host you can use this command:

```./vendor/bin/luya exporter/database/remote-replace-local "mysql:host=localhost;dbname=REMOTE_DB_NAME" "USERNAME" "PASSWORD"```

> Attention! This command will drop all tables in your current used database and replace them with the remote export.

To use this in a context where you aren't able to process user inputs (chained remote batch processing like in a deployer task) you can disable the security confirmation by adding the parameter `--interactive=0`. Obviously this should be used with extreme caution to prevent any unwanted data losses. For your safety there will be an automatically created database backup of the local db. The backup can be found in the local temporary system directory - the file name resembles like this: `uniqid() . '-BACKUP-'.time()`