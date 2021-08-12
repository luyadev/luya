# CMS page properties

Page properties are personalised settings you can apply to specific pages. Once a property has defined, it can be applied to every page. 

Let us assume you would like to use different colors on different pages, therefore you can create a color property where the user can select a specific color for each page. Once the property is set you can use them in your view files, or [blocks](app-blocks.md), or [layouts](app-cmslayouts.md) components.

Use cases:

+ Background image
+ Colors, CSS properties for contents
+ Specific meta information
+ Protecting a page

## Creating a new property

All properties must be in a folder called `properties` and must contain the suffix `Property` inside the filename. LUYA will automatically detect and setup all properties when you run the [import](luya-console.md) command. You can either create the properties folder inside your application or in your module folder to enable reusable modules with properties which will be attached automatically too.

Below you can see an example of a property (in `FooBarProperty.php`) for creating a text field which can be attached somewhere in your view files:

```php
namespace app\properties;

class FooBarProperty extends \luya\admin\base\Property
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

After running the import command, you will see the property in the CMS admin. To set the property for a page, do the following;

1. Go to the page in the CMS admin.
2. Press on the settings button in the top right corner.
3. Press *Page properties*.
4. Here you can find all the properties which you have defined as described above.

In order to understand the methods in depth refer to the API Guide {{\luya\admin\base\Property}}.

There is a set of predefined properties provided from which you can extend because some uses cases require that you override the `getValue()` method in order to change the value output. As this is a common scenario we have built classes so you can abstract this.

Predefined properties you might extend from:

+ {{luya\admin\base\ImageProperty}}
+ {{luya\admin\base\CheckboxProperty}}
+ {{luya\admin\base\CheckboxArrayProperty}}
+ {{luya\admin\base\RadioProperty}}

#### Image property Example

The image property is often used to return the path of an uploaded image, so you can abstract your property from {{\luya\admin\base\ImageProperty}} like in the example below:

```php
class MyImageProperty extends \luya\admin\base\ImageProperty
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

In order to use the above `MyImageProperty` just run: `<img src="<?= $item->getProperty('myImage'); ?>" />`. The `$item` is an object from the `menu` in your view. You could e.g. do the following where you find the property defined in the home page and use it:

```php
$property = Yii::$app->menu->home->getProperty('myImage');
$image = $prop->getValue();
echo Html::img($image, ['class' => 'yourImageClass']);
```

> All properties implement the magical method `__toString()` and will return the value from the `getValue()` method by default. Keep in mind that this is only true for the echo or return context. When checking for the existance of a value, explicitely use the `getValue()` method as otherwise the property object is returned, which always resolves to true.

## Access the property

You can access the properties in

+ [Menus](app-menu.md)
+ [CMS layouts](app-cmslayouts.md) or layouts
+ [CMS blocks](app-blocks.md)

#### Access in menus

Getting the value of a property for the current page, if it is not found `null` will be returned:

```php
Yii::$app->menu->current->getPropertyValue('foobar');
```

Working with a property object:

```php
Yii::$app->menu->current->getProperty('foobar');
```

A very common scenario is to add properties to an existing menu item like an image which should be used for the navigation instead of text. To collect the property for a menu item, the menu component has a `getProperty($varName)` method on each item. Collecting the menu and retrieving the page property `navImage` could be done as follows:

```php
<?php foreach(Yii::$app->menu->findAll(['parent_nav_id' => 0, 'container' => 'default']) as $item): ?>
<li>
    <a href="<?= $item->link; ?>">
        <!-- check if the property `navImage` is set for this page item we can access this property object. -->
        <?php if ($item->getProperty('navImage')): ?>
            <img src="<?= $item->getProperty('navImage'); ?>" alt="some-text"/> 
            <!-- equals to: <img src="<?= $item->getProperty('navImage')->getValue(); ?>" /> -->
        <?php endif; ?>
    </a>
</li>
<?php endforeach; ?>
```

> When dealing with large menus you can preload the models (including properties) for a given menu query by using {{luya\cms\menu\Query::preloadModels}} or {{luya\cms\Menu::findAll}} with the second statement `true`.

#### Access in layouts

In a layout you can always get a current property based on the current active menu item:

```php
Yii::$app->menu->current->getProperty('foobar');
```

#### Access in blocks

In a CMS block you have to access a property of the current page in a slightly different way:

```php
$this->getEnvOption('pageObject')->navItem->nav->getProperty('foobar');
```

Get all current properties:

```php
$this->getEnvOption('pageObject')->navItem->nav->properties;
```

## Events

You can use events inside your block to modify the behavior of your page:

|Name | Description |
|---  | ---
|`EVENT_BEFORE_RENDER`    |This event will be triggered before the page get rendered, you can set `$event->isValid` to `false` to prevent the system from further outputs.

Example of `EVENT_BEFORE_RENDER`:

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



