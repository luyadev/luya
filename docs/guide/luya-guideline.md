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

## CODING CONVENTIONS

The following conventions are used when contributing to the LUYA project.

### PHP 

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

### SQL

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

### CSS

http://cssguidelin.es/

### JS

https://github.com/airbnb/javascript

### JSON-SCHEMA:

http://json-schema.org/latest/json-schema-core.html


## Admin Module CSS Informations

The css and html files for the admin module are based on the following rules.

### Admin Design compile

> We now use [our Gulp Workflow](https://github.com/zephir/zephir-gulp-workflow) to compile all styles and js files in the admin module.  
> To use it, go to `modules/admin/src/resources` and run `gulp`. To install gulp and the dependencies on your System [follow the guide](https://github.com/zephir/zephir-gulp-workflow#dependencies).

To compile the styles you have to install the following tools and plugins:

(If ruby is not installed, run `sudo apt-get install ruby` on linux systems)

+ [Compass](http://compass-style.org/install/) (gem install compass) (Linux: `sudo apt-get install ruby-compass`)
+ [Autoprefixer-rails](autoprefixer-rails) (gem install autoprefixer-rails) (Linux: `sudo apt-get install ruby-autoprefixer-rails`)

> If you have not enough rights to run the command use *sudo* to run the commands, or change the permissions in the install directory of ruby.


If you have installed the tools successfull, you can now switch to the `resources` folder and run:

```sh
compass watch
```

or

```sh
compass compile
```

+ compile: will compile all styles once
+ watch: watching for changes in the file and runs compile automatic

Each module does have its own compass configratuons `config.rb`, so you have to run this process in each sub folder for the specific module.
