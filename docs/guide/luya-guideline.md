# Developer Guidelines

Below some rules how to deail with documentations, linking or using the php docs.

## Documentation & Guide

In order to make a Link somewhere inside the Guide or PHPDoc to a PHP Class use:

+ `{{\luya\base\Module}}` This will generate a link to the API for this class.
+ `{{\luya\base\Module::resolveRoute}}` Genrate a link to the luya\base\Module and method `resolveRoute()`.

In order to make links from the API PHPdocs to the Guide use:

+ `[[concept-tags.md]]` where the markdown file is a file located in `/docs/guide` folder..

## PHPDOC

All classes must have a php doc block which is sorted as follow including author and since tag.

```php
/**
 * Title for the class with Dot.
 *
 * The description of the class should be available like this also with a dot at the end.
 *
 * @author John Doe <john@example.com>
 * @since 1.0.0 
 */
class FooBar()
{
}
```
 
In order to refer to inherited methods use:

```php
/**
 * @inheritdoc
 */
public function init()
{

}
```

## CODING CONVENTIONS

The following conventions are used when contributing to the LUYA project.

#### PHP 

PSR2 Naming convention

(http://www.php-fig.org/psr/psr-2/)

This example encompasses some of the rules below as a quick overview:

```php
<?php
namespace Vendor\Package;

use FooInterface;
use BarClass as Bar;
use OtherVendor\OtherPackage\BazClass;

class Foo extends Bar implements FooInterface
{
    public function sampleFunction($a, $b = null)
    {
        if ($a === $b) {
            bar();
        } elseif ($a > $b) {
            $foo->bar($arg1);
        } else {
            BazClass::bar($arg2, $arg3);
        }
    }

    final public static function bar()
    {
        // method body
    }
}
```

#### SQL

SQL Datbase Table and Field namings:

+ Tables are singular
+ Table and column names are seperated by underscore (_)
+ The Primary Key is always ***id***
+ ***ALL*** tables have the module name as prefix. (e.g. admin_*)
+ Always use the FRONTEND-MODULE name as prefix if there are both.

table name examples

+ admin_user
+ admin_user_setting
+ admin_group
+ admin_user_group (ref table between user and group)
+ news_data
+ news_category

field name examples

+ table: admin_user
+ id
+ firstname
+ password_salt
+ group_id

#### CSS

http://cssguidelin.es/

#### JS

https://github.com/airbnb/javascript

#### JSON-SCHEMA:

http://json-schema.org/latest/json-schema-core.html
