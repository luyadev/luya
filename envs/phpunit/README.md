PHPUNIT
===

This environment exists to build the sql files for new releases based on a clean migration injecting menu items.

1. drop database / or create new one `luya_env_phpunit`
2. `cd configs && cp env.php.dist env.php`
3. `cd public_html`
4. `php index.php migrate`
5. `php index.php import`
6. `php index.php setup --email=test@luya.io --password=luyaio --firstname=John --lastname=Doe --interactive=0`
7. `php index.php data/setup`
8. Export the generate Database `luya_env_phpunit`
