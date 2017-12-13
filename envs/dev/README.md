Dev Environment
=======================

1. Open `dev` folder in your Terminal.
2. Install Dependencies `composer install`
3. Initialize submodules: `git submodule init`
3b. Update the head for your submodules: `git submodule update`
4. Rename `env.php.dist` to `env.php` and modify your *Database connection component* to match your local env settings.
5. Change to the *public_html* folder with `cd public_html`
6. Execute `php index.php migrate`, then import files into database `php index.php import` and afterwards execute the setup command `php index.php admin/setup`.
7. Access the *public_html* folder in your browser and your ready to go!

+ [Installation instructions](https://luya.io/guide/install)
+ [API Documentation](https://luya.io/api)
+ [Collaboration Guide](https://luya.io/guide/luya-collaboration)

Questions and Problems
----------------------

If you have any question or problem, don't hesitate to create a `New issue` on the project repository.

+ [Questions & Issues](https://github.com/zephir/luya/issues)