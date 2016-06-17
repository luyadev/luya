Upgrading Luya
==============

This page describes how to update an existing luya instance to the newest version. The current version of LUYA is `1.0.0-beta6`.

> This guide explains how to upgrade from `1.0.0-beta5` to `1.0.0-beta6`.

### Composer

change the luya versions for each modules and luya itself in you your composer.json

```
"require": {
    "luyadev/luya-core" : "1.0.0-beta6",
    "luyadev/luya-module-cms" : "1.0.0-beta6",
    "luyadev/luya-module-cmsadmin" : "1.0.0-beta6",
    "luyadev/luya-module-admin" : "1.0.0-beta6"
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

Now refresh all existing importer components with the import commmand

```sh
./vendor/bin/luya import
```

#### Updater/Versions

In beta we have introduced cms page version so you have to run the following command once, after the migrate/import command:

```sh
./vendor/bin/luya command cmsadmin/updater/versions
```

Your system is now up to date. Don't forget to check the *CHANGELOG.md* for backward compatibility breaks *[BC BREAK]*.