# Upgrading LUYA

This page describes how to update an existing LUYA instance to the latest version. The current version of LUYA is `1.0.0-RC3`.

> **Before upgrading, [read the Backward compatibility breaks Guide](https://github.com/luyadev/luya/blob/master/UPGRADE.md)**

### Composer

change the LUYA versions for each modules and luya itself in you your composer.json

```json
"require": {
    "luyadev/luya-core" : "1.0.0-RC3",
    "luyadev/luya-module-cms" : "1.0.0-RC3",
    "luyadev/luya-module-admin" : "1.0.0-RC3"
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

Now refresh all existing importer components with the import commmand:

```sh
./vendor/bin/luya import
```

Sometimes image filters changes and you should reprocess all flemanager thumbnails:

```sh
./vendor/bin/luya admin/storage/process-thumbnails
```

### Upgrade the application code

Read the [CHANGELOG](https://github.com/luyadev/luya/blob/master/CHANGELOG.md) to see all new, fixed and breaking features. The **most important** when upgrading into another Version is to [read the BC Breaks Guide](https://github.com/luyadev/luya/blob/master/UPGRADE.md) in order to see all changes you have to make in your application to run the newest version of LUYA.
