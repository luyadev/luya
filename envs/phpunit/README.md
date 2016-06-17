PHPUNIT
===

This environment exists to build the sql files for new releases based on a clean migration injecting menu items.

1. drop database
2. cd public_html
3. php index.php migrate
4. php index.php import
5. php index.php setup (Login: test@luya.io pass: testluyaio)
6. php index.php data/setup
