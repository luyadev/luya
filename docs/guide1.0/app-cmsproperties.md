CMS Page Properties
========================

What are properties?
--------------------

As the name already says, those are properties you can attach to a page you want. For example if you like to use different colors on different pages you can create a color property where the user can select a specific color for each page. Once the property is set you can use them in your view files for blocks or layouts.

Example use cases:

+ Background image
+ Colors, css properties for contents
+ Specific meta informations
+ Protected a page

Create a new property
------------------------

All properties must be in a folder called `properties` and must contain the suffix `Property`, LUYA will automatically detect and setup all properties when you run the [import](luya-console.md) command. You can create the properties folder inside your app namespace or inside a module so you can create reusable modules with properties which will be attached automatically.

Example property for creation of a textfield wich can be attached somewhere in your view files:

```php
<?php

namespace app\properties;

class TestProperty extends \admin\base\Property
{
    public function varName()
    {
        return 'foobar';
    }    
    
    public function label()
    {
        return 'Foo Bar Label';
    }
    
    public function type()
    {
        return self::TYPE_TEXT;
    }
}
```

After running the import command you will see the property in the CMS admin.


### Class methods

|methode	|Optional	|Description
|---		|---		|---
|varName	|no		|The name of the variable, under this name you can access the property later
|label		|no		|The human readable name of the property. This will be visibile for administration users.
|type		|no		|Choose the type of your variable [available types](app-block-types.md).
|options	|yes	|If the variable type does have options you have to define them in this method.
|defaultValue|yes	|This will be the initvalue of the variable, default is `false`.

Access the property
---------------------------

You can access the properties in

+ [Blocks](app-blocks.md)
+ Layouts
+ [Menus](app-menu.md)

> If you access a property but the properties has not been append to this page you will get the `defaultValue` defined from your block object.

### in Blocks

```php
$this->getEnvOption('pageObject')->nav->getProperty('foobar');
```

Get all properties for this page

```php
$this->getEnvOption('pageObject)->nav->properties;
```

### in Layouts

There is a page component `Yii::$app->page` which will be registered when using the same, the page component contains information about your current page.


```php
Yii::$app->page->getProperty('my-prop');
```

get all properties

```php
Yii::$app->page->properties;
```

### in Menus

> since 1.0.0-beta8

A very common scenario is to add properties to an existing menu item like an image which should be used for the navigation instead of text. To collect the property for a menu item the menu component does have a `getProperty($varName)` method on each item. For example collecting the menu and retrieving the page property `navImage` could be done as followed:

```php
<?php foreach(Yii::$app->menu->find()->where(['parent_nav_id' => 0, 'container' => 'default'])->all() as $item): ?>
<li>
	<a href="<?= $item->link; ?>">
		<?php /* now depending on the if the property `navImage` is set for this page item we can access this property object. */
		if ($item->getProperty('navImage')): ?>
		<img src="<?= $item->getProperty('navImage')->getValue(); ?>" />
		<? endif; ?>
	</a>
</li>
<?php endforeach; ?>
```

This method allows you find and evaluate properties for menu items and allows you also to use `Yii::$app->menu->current->getProperty('xyz')` instead of using `Yii::$app->page->getProperty('xyz')`.


Events
------

You can use events inside your block to modified the behavior of your page:

|Name | Description |
|---  | ---
|EVENT_BEFORE_RENDER    |This event will be triggered before the page get render, you can set `$event->isValid` to false to prevent the system from further outputs.

### Example of EVENT_BEFORE_RENDER

```php
public function init()
{
    $this->on(self::EVENT_BEFORE_RENDER, [$this, 'beforeRender']);
}

public function beforeRender($event)
{
	if ($this->thisMethodReturnsFalseWhyEver()) {
		Yii::$app->response->redirect('https://luya.io');
    	$event->isValid = false;
	}
}
```



