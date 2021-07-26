# Developer guidelines

Here are some simple rules how to deal with documentations, linking or using PHPDoc.

## Documentation & guide

Informations about creating guides and how they are displayed on luya.io:

+ Heading 1 titles will be removed from rendering on luya.io and the navigation title is used instead
+ Heading 2 titles will be used to automatically generate the table of contents on luya.io

In order to create a link inside the guide or PHPDoc to a PHP class use the following syntax:

+ `{{luya\base\Module}}` This will generate a link to the API for the given class name.
+ `{{luya\base\Module::$apis}}` Generate a link to an API class with property `$apis`.
+ `{{luya\base\Module::resolveRoute()}}` Generate a link to an API class with the method `resolveRoute()`.

If you want to link from the API PHPDoc to the guide use:

+ `[[concept-tags.md]]` Assuming the Markdown file would be located in the `/docs/guide` folder.

When dealing with a Controller, Action or another PHP names use single quotes \`MyController\`. For example `MyController` would name the controller defined in the file `MyController.php` with the action `indexAction()`, same notation goes for PHP variables like `$foobar`.

### Wording

This represents a guideline how words and proper nouns should be written in the documentation:

+ LUYA – always capitalized
+ ActiveRecord
+ ActiveWindow
+ admin UI – instead of Admin, admin module or Admin UI
+ AJAX
+ AngularJS
+ Apache
+ API
+ AWS
+ BBCode
+ CDN
+ CI
+ CMS
+ Composer
+ CORS
+ CRUD
+ CSS
+ DNS
+ Docker
+ DRY
+ e.g. – instead of f.e., for example or similar expressions
+ FAQ
+ GET – REST API command
+ Git
+ GitHub
+ HTML
+ HTTP
+ i18n
+ JavaScript
+ jQuery
+ JS
+ JSON
+ JSON-LD
+ JWT
+ LAMP
+ macOS
+ MAMP
+ Markdown
+ MVC
+ MySQL
+ NgRest
+ OpenAPI
+ OS
+ PHP
+ PHPDoc
+ PHPMailer
+ POST – REST API command
+ REST
+ SCSS
+ SQL
+ SSH
+ SVN
+ UI
+ Unix
+ URL
+ VCS
+ WAMP
+ XAMPP
+ Yii
+ yourdomain.com – instead of example.com, yourproject.com, etc.

It should be avoided to use personal pronouns (e.g. we have this, we recommend that, you can, etc.), please use impersonal pronouns (e.g. there is this, it’s recommended that, etc.).

## Coding conventions

The following conventions have to be used when contributing to the LUYA project.

### PHP

[PSR2 Naming convention](http://www.php-fig.org/psr/psr-2/). This example encompasses some of the rules below as a quick overview:

```php
<?php
namespace Vendor;

use FooInterface;
use BarClass as Bar;

class Foo extends Bar implements FooInterface
{
    public function sampleFunction($a, $b = null)
    {
        if ($a === $b) {
            
        } elseif ($a > $b) {
            
        } else {
            
        }
    }

    final public static function bar()
    {
        
    }
}
```

The example above shows how to indent brackets.

### PHPDoc

All classes have to use a standard PHPDoc block including the *author* and *since* tag.

```php
/**
 * Title for the class with Dot.
 *
 * The description of the class with a dot at the end.
 *
 * @property string $virtualProperty This describes the response of the vritualProperty
 * @property \luya\base\Module $virtualProperty This describes the response but ensures class linkable IDE abilities.
 *
 * @see Take a look at luya\base\Module::resolveRoute()
 * @deprecated Deprecated in 1.0.10 will be removed in 2.0.0 use luya\base\Module instead.
 * @author John Doe <john@example.com>
 * @since 1.0.0
 */
class FooBar()
{
}
```

> If there are `@property` tags available for the class, they should be separated from the tags below.
 
In order to refer to inherited methods use:

```php
/**
 * @inheritdoc
 */
public function init()
{

}
```

Example for using since tags in a new method of a class:

```php
class FooBar
{
    /**
     * Register new Article.
     *
     * An article, such as a news article or piece of investigative report.
     * Newspapers and magazines have articles of many different types and this is intended to cover them all.
     *
     * @param array $config Optional config array to provided article data via setter methods.
     * @return \luya\web\jsonld\Article
     * @since 1.0.1
     */
     public static function article(array $config = [])
     {
         return self::addGraph((new Article($config)));
     }
}
```

With introduction of LUYA Admin OpenAPI Generator we make use of the `@uses` tag to reference POST Request Bodies. As the POST data is not defined in the `@param` section we recommend to use `@uses`, see [[app-openapi.md]].

Which would be equals to `$_POST['username']` and `$_POST['password']`.

### SQL

SQL Database table and field namings:

+ Tables are singular
+ Table and column names are seperated by underscore (_)
+ The primary key is always ***id***
+ ***All*** tables have to use the module name as prefix. (e.g. admin_*)
+ Always use the frontend-module name as a prefix if there are both modules available (frontend and backend).

Table name examples:

+ admin_user
+ admin_user_setting
+ admin_group
+ admin_user_group (Reference table between user and group)
+ admin_user_group_ref (Alternatively the reference table could contain the suffix `_ref` or `_rel`)
+ news_data
+ news_category

Field name examples (for table *admin_user*):

+ id
+ firstname
+ password_salt
+ group_id


### SCSS

The SCSS folder contains all SCSS files and is structured as follows:

| Folders | Description |
|---------|-------------|
| `base/` | Contains basic styles like the reboot, angular fixes and default styles for tags |
| `browser-fixes/` | Contains specific browser fixes, for each fix we use a different file (e.g. `_ie.scss`) |
| `components/` | Here all the components are stored. See "components" further down |
| `fonts/` | Contains font-face and mixins for the specific font. |
| `helpers/` | Mixins and functions |
| `variables/` | All variables used in this project |

**Components/**

All classes for a component are prefixed with the components name. If you have to select something by HTML tag, be sure that there is no way to select it by a specific class (if you can add a class to the element, go for it).
Children of a component are seperated with a `-`.

Example:

Component: `_crud.scss`

Classes in component: `.crud`, `.crud-header`, `.crud-title`, `.crud-table`

HTML:

```html
<div class="crud">
 <div class="crud-header">
  <h1 class="crud-title">Title</h1>
 </div>
 <div class="crud-table">
  <table class="table">...</table>
 </div>
</div>
```

> You can see that all classes for the `crud` component are prefixed with `crud-`. That way we always know what we can find in which SCSS file. In the HTML you can see that there is a standalone component `table`, wrapped by the class `crud-table`. This results in an extra SCSS component `_table.scss`.

