# CMS Page Properties

Page properties are personalised settings you can apply to specific pages. 

For example, if you want to use different colors on different pages, you can create a color property where the user can select a specific color for each page. Once the property is set you can use them in your view files for [Blocks](app-blocks.md) or [Layouts](app-cmslayouts.md) components.

Use cases:

+ Background image
+ Colors, css properties for contents
+ Specific meta informations
+ Protecting a page

## Creating a new property


All properties must be in a folder called `properties` and must contain the suffix `Property`. LUYA will automatically detect and setup all properties when you run the [import](luya-console.md) command. You can either create the properties folder inside your application or module folder to enable reusable modules with properties which will be attached automatically.

Example of a property for creating a textfield wich can be attached somewhere in your view files:

```php
<?php

namespace app\properties;

class TestProperty extends \luya\admin\base\Property
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

After running the import command you will see the property in the CMS admin. In order to understand the methods used in details refer to the API Guide {{\luya\admin\base\Property}}.

We are also have a set of predefined propertys you can extend from, this i cause some blocks have to override the `getValue()` method in order to change the value output, as this is common scenario we have built classes you can abstract from.

#### Image Property

The image property is often used to return upload an image and return the path for, so you can abstract your property from {{\luya\admin\base\ImageProperty}} like the example below:

```php
class MyImage extends \luya\admin\base\ImageProperty
{
    public function varName()
    {
        return 'myImage';
    }
    
    public function label()
    {
        return 'My Image';
    }
}
```

In order to get use the above MyImage property just run: `<img src="<?= $item->getProperty('myImage'); ?>" />`.

> All properties implement the magical method `__toString()` and will return the return value from the `getValue()` method by default. Keep in mind that this is only true for the echo or return context. When checking for the existance of a value, explicitely use the `getValue()` method as otherwise the Property object is returned, which always resolves to true.

Predefined properties

+ {{luya\admin\base\ImageProperty}}
+ {{luya\admin\base\CheckboxProperty}}

## Get the Propety

You can access the properties in

+ [CMS Blocks](app-blocks.md)
+ [CMS Layouts](app-cmslayouts.md) or Layouts
+ [Menus Item](app-menu.md)

#### in Menus

A very common scenario is to add properties to an existing menu item like an image which should be used for the navigation instead of text. To collect the property for a menu item the menu component does have a `getProperty($varName)` method on each item. For example collecting the menu and retrieving the page property `navImage` could be done as followed:

Getting the value of a Property, if not found null will be returned.

```php
echo Yii::$app->menu->current->getPropertyValue('myProperty');
```

Working with the Property Object:

```php
<?php foreach(Yii::$app->menu->findAll(['parent_nav_id' => 0, 'container' => 'default']) as $item): ?>
<li>
	<a href="<?= $item->link; ?>">
		<?php /* now depending on the if the property `navImage` is set for this page item we can access this property object. */
		if ($item->getProperty('navImage')): ?>
		<img src="<?= $item->getProperty('navImage'); ?>" /> // equals to: <img src="<?= $item->getProperty('navImage')->getValue(); ?>" />
		<? endif; ?>
	</a>
</li>
<?php endforeach; ?>
```

This method allows you find and evaluate properties for menu items and allows you also to use `Yii::$app->menu->current->getProperty('xyz')`.

> When dealing with large menus you can preload the models (with its properties) for a given menu query use {{luya\cms\menu\Query::preloadModels}} or {{luya\cms\Menu::findAll}} with second statement `true`.

#### in Layouts

In the layout you can always get the current propertys based on the current active menu item.

```php
Yii::$app->menu->current->getProperty('my-prop');
```

#### in Blocks

```php
$this->getEnvOption('pageObject')->nav->getProperty('foobar');
```

Get all properties for this page

```php
$this->getEnvOption('pageObject)->nav->properties;
```

## Events

You can use events inside your block to modified the behavior of your page:

|Name | Description |
|---  | ---
|EVENT_BEFORE_RENDER    |This event will be triggered before the page get render, you can set `$event->isValid` to false to prevent the system from further outputs.

#### Example of EVENT_BEFORE_RENDER

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



