# LUYA Unit Test

Unit testing is an integral part of LUYA. Every new class and function should be accompanied by a dedicated unit test.

## Unit test a single class

1. Create the test for your class in `tests/` within the appropriate folder (for example `InflectorHelperTest.php` in `tests/core/helpers`).
For a general guide to create PHP Unit Tests refer to [Getting Started with PHPUnit](https://phpunit.de/getting-started.html) or the [Official Documentation](https://phpunit.de/manual/current/en/index.html).
2. Make sure your composer packages are updated by running `composer install` within the local LUYA dev package.
3. Run the tests for your class by executing `./vendor/bin/phpunit tests/core/helpers/InflectorHelperTest.php` (if you want to test to the `InflectorHelperTest.php` for example)

## Unit test everything with a complete suite test

1. Create a new database (for example *luya_env_phpunit*)
2. Insert the database dump for your LUYA version from *tests/data/sql/* (for example `1.0.0.sql`)
3. Rename `phpunit.xml.dist` in LUYA root to `phpunit.xml`
4. Change *dsn*, *username* and *password* in `phpunit.xml`
5. Ensure you have installed the current composer packages by running `composer install` within the local LUYA dev package.
6. Execute the *phpunit* binary file with `./vendor/bin/phpunit`.