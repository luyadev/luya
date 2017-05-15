# Developer Guidelines

Below some rules how to deail with documentations, linking or using the php docs.

## Documentation & Guide

In order to make a Link somewhere inside the Guide or PHPDoc to a PHP Class use:

+ `{{\luya\base\Module}}` This will generate a link to the API for this class.
+ `{{\luya\base\Module::resolveRoute}}` Genrate a link to the luya\base\Module and method `resolveRoute()`.

In order to make links from the API PHPdocs to the Guide use:

+ `[[concept-tags.md]]` where the markdown file is a file located in `/docs/guide` folder..

## PHPDOC

All classes must have a php doc block which is sorted as follow including author and since tag.

```php
/**
 * Title for the class with Dot.
 *
 * The description of the class should be available like this also with a dot at the end.
 *
 * @property string $virtualProperty This describes the response of the vritualProperty
 * @property \luya\base\Module $virtualProperty2 This describes the response but ensures class linkable IDE abilities.
 *
 * @author John Doe <john@example.com>
 * @since 1.0.0 
 */
class FooBar()
{
}
```

> When `@property` are available they are separated to the other tags below.
 
In order to refer to inherited methods use:

```php
/**
 * @inheritdoc
 */
public function init()
{

}
```

## Versioning

This project make usage of the [Yii Versioning Strategy](https://github.com/yiisoft/yii2/blob/master/docs/internals/versions.md).

## CODING CONVENTIONS

The following conventions are used when contributing to the LUYA project.

### PHP 

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

### SQL

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
+ admin_user_group (Reference table between user and group)
+ admin_user_group_ref (Alternative the reference table can contain the suffix `_ref` or `_rel`)
+ news_data
+ news_category

field name examples

+ table: admin_user
+ id
+ firstname
+ password_salt
+ group_id

### CSS

http://cssguidelin.es/

### JS

https://github.com/airbnb/javascript

### JSON-SCHEMA:

http://json-schema.org/latest/json-schema-core.html


## Admin Module CSS Informations

The css and html files for the admin module are based on the following rules.

### Admin Design compile

To compile css and js to one file we use [our Gulp Workflow](https://github.com/zephir/zephir-gulp-workflow).  
To install gulp and the dependencies on your System [follow the guide](https://github.com/zephir/zephir-gulp-workflow#dependencies).

Everything will be compiled to a folder `dist/` in the corresponding `{module}/resources` folder.

> **Important:** The JS files and their order are all defined in the `compileConfig.js`. If you add a new JS file, make sure to add it in the config as well.

**Module: admin**  
Run `gulp` in the following directory: `modules/admin/src/resources`.

**Module: cmsadmin**  
Run `gulp` in the following directory: `modules/cms/src/admin/resources`.
