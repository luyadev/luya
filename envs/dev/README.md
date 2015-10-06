Dev Environment
=======================

1. Open `dev` folder in your Terminal.
2. Install Dependencies `composer install`
3. Rename `server.php.dist` to `server.php` and modify your *Database connection component* to match your local env settings.
4. Execute the `./vendor/bin/luya migrate`, then import files into database `./vendor/bin/luya import` and afterwards execute the settup command `./vendor/bin/luya exec/setup`.
5. Access the *public_html* folder in your browser and your ready to go!

+ [Installation instructions](http://luya.io/de/dokumentation/install)
+ [Documentation](http://luya.io)
+ [Collaboration Guide](http://luya.io/de/dokumentation/luya-collaboration)

Questions and Problems
----------------------

If you have any question or problem, don't hesitate to create a `New issue` on the project repository.

+ [Questions & Issues](https://github.com/zephir/luya/issues)