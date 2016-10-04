Upgrading Luya
==============

This page describes how to update an existing luya instance to the newest version. The current version of LUYA is `1.0.0-beta8`.

### Composer

change the luya versions for each modules and luya itself in you your composer.json

```
"require": {
    "luyadev/luya-core" : "1.0.0-rc1",
    "luyadev/luya-module-cms" : "1.0.0-rc1",
    "luyadev/luya-module-admin" : "1.0.0-rc1"
}
```

After updating the file execute the update command of composer, this can take a few minutes.

```sh
composer update
```

Now you got a new composer lock file, which can be used for other team members to install the new luya version.

> If you get a composer update error, make sure you have set `"minimum-stability" : "beta"`.

### Console

After updating composer, excecute the following command to upgrade the Database.

```sh
./vendor/bin/luya migrate
```

Now refresh all existing importer components with the import commmand:

```sh
./vendor/bin/luya import
```

Sometimes image filters changes and you should reprocess all flemanager thumbnails:

```sh
./vendor/bin/luya storage/process-thumbnails
```

### Upgrade the application code

Read the [CHANGELOG](https://github.com/luyadev/luya/blob/master/CHANGELOG.md) to see all new, fixed and breaking features. The **most important** when upgrading into another Version is to [read the BC Breaks Guide](https://github.com/luyadev/luya/blob/master/UPGRADE.md) in order to see all changes you have to make in your application to run the newest version of LUYA.