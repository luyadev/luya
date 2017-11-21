Dev Environment
=======================

1. Open `dev` folder in your Terminal.
2. Install Dependencies `composer install`
3. Rename `env.php.dist` to `env.php` and modify your *Database connection component* to match your local env settings.
4. Change to the *public_html* folder with `cd public_html`
5. Execute `php index.php migrate`, then import files into database `php index.php import` and afterwards execute the setup command `php index.php admin/setup`.
6. Access the *public_html* folder in your browser and your ready to go!

+ [Installation instructions](http://luya.io/de/dokumentation/install)
+ [Documentation](http://luya.io)
+ [Collaboration Guide](http://luya.io/de/dokumentation/luya-collaboration)

Questions and Problems
----------------------

If you have any question or problem, don't hesitate to create a `New issue` on the project repository.

+ [Questions & Issues](https://github.com/zephir/luya/issues)

Bower assets

```sh
"require-dev": {
    "bower-asset/jquery-ui" : "1.11.4",
    "bower-asset/angular" : "1.4.8",
    "bower-asset/angular-i18n" : "1.4.8",
    "bower-asset/angular-resource": "1.4.8",
    "bower-asset/angular-ui-router" : "0.2.15",
    "bower-asset/angular-loading-bar" : "0.8.0",
    "bower-asset/angular-dragdrop" : "1.0.13",
    "bower-asset/angular-slugify" : "1.0.1",
    "bower-asset/twig.js" : "0.8.6",
    "bower-asset/ng-file-upload" : "11.0.2",
    "bower-asset/ng-wig" : "2.3.3"
},
```