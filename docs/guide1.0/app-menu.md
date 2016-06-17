Menu Navigation
===========

The `menu` component allows you to collect data to build the websites navigations. The menu component is part of the `cms` module.

You can access the `menu` component trough `Yii::$app->menu`. This component will help you to create menus, find childs, get items of containers, etc. The menu component will automatically added to the componsten when you register the cms (menu component is part of the cms module).

When you request a menu item you will always get a [Menu-Item-Object](https://luya.io/api/cms-menu-item.html) object which provides a lot of getter methods.

The *Menu-Component* will automatic load the current active menu items based on your current language (which will be evulated by the `composition` component).

Get the current site
----------------------

One of the most important features is to get the current active menu item, to access this [Menu-Item-Object](https://luya.io/api/cms-menu-item.html) you can use `getCurrent()` or as its a `yii\base\Object` you can access it trough `current`.

```php
echo Yii::$app->menu->current->link;
```

or

```php
echo Yii::$app->menu->getCurrent()->getLink();
```

Where `getCurrent()` / `current` returns a [Menu-Item-Object](https://luya.io/api/cms-menu-item.html).

Get Homepage
------------------

To get the homepage us the `getHome()` method which will return a [Menu-Item-Object](https://luya.io/api/cms-menu-item.html).

```php
echo Yii::$app->menu->home->title;
```

Get menu data
-------------

To read an list specific parts of the menu use the `find()` method (which is somehwat equilvalent implementation of Yii2 ActiveRecord pattern:

```php
foreach(Yii::$app->menu->find()->where(['parent_nav_id' => 0])->all() as $itemObject) {
    var_dump($itemObject);
}
```

The example obe would look in a sql expression somewhat like this `WHERE parent_nav_id = 0`.

```
foreach(Yii::$app->menu->find()->where(['parent_nav_id' => 0, 'is_active' => 1])->all() as $itemObject) {
    var_dump($itemObject);
}
```
This will look somewhat like this `WHERE parent_nav_id = 0 AND is_active = 1`.

Another example with differnte conditions:

```php
where(['!=', 'is_active', 0])->andWhere(['==', 'parent_nav_id', 0]); // WHERE is_active != AND parent_nav_id === 0
```

|Operator |Equals
|---|---
|<= | Smaller as and equal
|<  | Smaller as
|>  | Bigger as
|>= | Bigger as and equal
|=  | Equals
|== | Equal and type comparison

Breadcrumbs output
--------------------

To get the current breadcrumbs of the current menu item you can use the item object method `getTeardown`, so you can get all items from the item and below. The `getTeardown()` method works of course on every Nav-Item-Object, so you can teardown whatever you like to.

```php
foreach(Yii::$app->menu->current->teardown as $item) {
    echo '<li><a href="' . $item->link . '">' . $item->title . '</a></li>';
}
```

Languages (composition)
----------------------

In Addition to the Menu componet the `composition` componet is used to retrieve the current language settings based on differnet inputs, you can use the composition pattern without the cms, but if you have included the cms it will have to match the language table.

```php
$langShortCode = Yii::$app->composition['langShortCode'];
```

To get the full composition pattern.

```
echo Yii::$app->composition->full;
```

> We will add an extra section for this, later.

Link syntax in CMS blocks
------------------------

We have built some small helper commands you can use whever you are in your cms. You can also parse our own content with `cms\helpers\TagParser::convert($content)`.

|Link Syntax|Output/Description
|----       |----		
|`link [3] (Alternativ Link Name)`  |`<a href="url/to/3">Alternativ Link Name</a>`
|`link [3]`                           |`<a href="url/to/3">Name of 3</a>`
|`link [www.luya.io]`                 |`<a href="http://www.luya.io">luya.io</a>`
|`link [luya.io] (go to Docu)` |`<a href="http://luya.io">Go to docu</a>`
|`link [//go/there]`|`<a href="http://example.com/go/there">go/there</a>` The slash will be replaced be the current domain.
|`link [//go/there] (relativ link description)`|`<a href="http://example.com/go/there">relativ link description</a>`
|`file [1]` |Get the path to the file with the ID 1

**ATTENTION:** The obven metnioned `Link Syntax` muss be used **without** Whitspaces.

To the the page number (which is 3, used above) you will find the Page-Id in when hover over the menu item in the cms admin menu-tree:

![Page ID](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide1.0/img/cms-nav-page-id.jpg "Seiten ID")

Menu Item Injection
------------------

> since 1.0.0-beta5

There is also a possibility to inject data into the menu component direct from every part of your web application.

An item inject gives a module the possibility to add items into the menu Container.

The most important propertie of the injectItem clas is the `childOf` definition, this is where you have to define who is the parent *nav_item.id*.

An item inject contain be done during the eventAfterLoad event to attach at the right initializer moment of the item, but could be done any time. To inject an item use the `injectItem` method on the menu Container like below:

```
Yii::$app->menu->injectItem(new InjectItem([
    'childOf' => 123,
    'title' => 'This is the inject title',
    'alias' => 'this-is-the-inject-alias',
]));
```

To attach the item at right moment you can bootstrap your module and use the `eventAfterLoad`
event of the menu component:

```
Yii::$app->menu->on(Container::MENU_AFTER_LOAD, function($event) {

    $newItem = new InjectItem([
        'childOf' => 123,
        'title' => 'Inject Title',
        'alias' => 'inject-title',
    ]);

    $event->sender->injectItem($newItem);
});
```