Upgrading Luya
==============

This page describes how to update an existing luya instance to the newest version. Der current version is `1.0.0-beta3`.

> This guide explains how to upgrade from `1.0.0-beta1` to `1.0.0-beta`.

### Composer

change the luya versions for each modules and luya itself in you your composer.json

```
"require": {
    "zephir/luya" : "1.0.0-beta3",
    "zephir/luya-module-cms" : "1.0.0-beta3",
    "zephir/luya-module-cmsadmin" : "1.0.0-beta3",
    "zephir/luya-module-admin" : "1.0.0-beta3"
}
```

After updating the file execute the update command of composer, this can take a few minutes.

```sh
composer update
```

Now you got a new composer lock file, which can be used for other team members to install the new luya version.

### Console

After updating composer, excecute the following command to upgrade the Database.

```sh
./vendor/bin/luya migrate
```

Now refresh all existing importer components with the import commmand

```sh
./vendor/bin/luya import
```

Your system is now up to date. Don't forget to check the *CHANGELOG.md* for backward compatibility breaks *[BC BREAK]*.