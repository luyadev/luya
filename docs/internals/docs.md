# DOCUMENTATION

In order to make a Link somewhere inside the Guide or PHPDoc to a PHP Class use:

+ {{\luya\base\Module}} This will generate a link to the API for this class.
+ {{\luya\base\Module::resolveRoute}} Genrate a link to the luya\base\Module and method `resolveRoute()`.

In order to make links from the API PHPdocs to the Guide use:

+ [[concept-tags.md]] Where the markdown file is a file located in https://github.com/luyadev/luya/tree/master/docs/guide.

To refer to inherite methods use:

```php
/**
 * @inheritdoc
 */
public function init()
{

}
```