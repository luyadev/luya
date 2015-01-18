LANGUAGE CONVENTIONS
===================

Table of contents

- sql
- php
- css
- js

SQL
----------------------
+ Tables are singular
+ Table and column names are seperated by underscore (_)
+ The Primary Key is always ***id***
+ ***ALL*** tables have the module name as prefix. (e.g. admin_*)
+ Always use the FRONTEND-MODULE name as prefix if there are both.

table name examples
```
admin_user
admin_user_setting
admin_group
admin_user_group (ref table between user and group)
news_data
news_category
```

field name examples
```
table: admin_user
id
firstname
password_salt
group_id
```


PHP
---------
PSR2 Naming convention

### Example

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

CSS
-----

http://cssguidelin.es/

JS
-----

https://github.com/airbnb/javascript
