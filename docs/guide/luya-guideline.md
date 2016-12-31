# Developer Guidelines

Below some rules how to deatil with documentations, linking or using the php docs.

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
