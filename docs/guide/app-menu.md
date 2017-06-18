# Menu Component

The {{\luya\cms\Menu}} component allows you to build the websites navigations. The menu component is part of the **cms** module.

You can access the {{\luya\cms\Menu}} component trough `Yii::$app->menu`. This component help you to create menus, find childs, get items of containers, get propertie data and much more. The menu component is automatically registered when adding the CMS Module to your config.

When you request a menu item, you will always get a {{\luya\cms\menu\Item}} object which provides a lot of getter methods.

The menu component automatically loads the {{\luya\cms\Menu::getCurrent}} active menu item based on your current language which will be evaluated by the {{\luya\web\Composition}} component.

## Get the current Page

One of the most important features is to get the current active menu item, to retrieve the current menu object use {{\luya\cms\Menu::getCurrent}}. 

```php
echo Yii::$app->menu->current->link; // equal: Yii::$app->menu->getCurrent()->getLink():
```

Where {{\luya\cms\Menu::getCurrent}} returns a {{\luya\cms\menu\Item}} you can access other informations like {{\luya\cms\menu\Item::getLink}}, {{\luya\cms\menu\Item::getTitle}} etc.

## Get the Homepage

To get the homepage object use {{\luya\cms\Menu::getHome}} method which will return a {{\luya\cms\menu\Item}} as well.

```php
echo Yii::$app->menu->home->title; // equal: Yii::$app->menu->getHome()->getTitle();
```

## Building menu Navigations

To list navigation data of the menu use the {{\luya\cms\Menu::find}} method which returns a {{\luya\cms\menu\Query}} object you can defined where statements and return either {{\luya\cms\menu\Query::one}}, {{\luya\cms\menu\Query::all}} or {{\luya\cms\menu\Query::count}}. To shorten you can use the {{\luya\cms\Menu::findAll}} or {{\luya\cms\Menu::findOne}} method.

Using {{\luya\cms\menu\Query::one}} or {{\luya\cms\Menu::findOne}} return an {{\luya\cms\menu\Item}}. Foreachable responses from {{\luya\cms\menu\Query::all}} or {{\luya\cms\Menu::findAll}} return an {{\luya\cms\menu\Iterator}} instead.

#### findAll()

A common basic example to retrieve all menu items from the root level of a navigation using {{\luya\cms\Menu::findAll}}:

```php
<ul>
<?php foreach (Yii::$app->menu->findAll(['parent_nav_id' => 0]) as $item): ?>
    <li><a href="<?= $item->link;"><?= $item->title; ?></a>
<?php endforeach; ?>
</ul>
```

You can also add more where parameters by adding another key with value expression:

```php
findAll(['parent_nav_id' => 0, 'container' => 'footer']);
```

#### find()

Sometimes you are looking for more complex operator expression there for you can build menu query with the {{\luya\cms\Menu::find}} method:

```php
Yii::$app->menu->find()->where(['!=', 'is_active', 0])->andWhere(['==', 'parent_nav_id', 0])->all();
```

Therefore you can use different operators inside the where query:

|Operator |Equals
|---|---
|<= | Smaller as and equal
|<  | Smaller as
|>  | Bigger as
|>= | Bigger as and equal
|=  | Equals
|== | Equal and type comparison

#### findOne()

To retrieve just a single menu item from the menu component based on parameters, you can use the {{\luya\cms\Menu::findOne}} method:

```php
echo Yii::$app->menu->findOne(['id' => 1])->link;
```

#### Hidden Data

For more flexible menu queries, you can use the Query object. As an example, in order to search for top-level pages, including hidden ones, you would use:

```php
Yii::$app->menu->find()->where(['parent_nav_id' => 0])->with(['hidden'])->all();
```

## Breadcrumbs

To get the current breadcrumbs of the current menu item you can use the item object method {{\luya\cms\menu\Item::getTeardown}} to collect all items downwards from the current item, teardown contains the menu itself, {{\luya\cms\menu\Item::getParents} is almost equals but without the element itself you have applied the method. The {{\luya\cms\menu\Item::getTeardown}} method works of course on every {{\luya\cms\menu\Item}}, so you can teardown whatever you like to.

```php
<ol>
    <li><a href="<?= Yii::$app->menu->home->link; ?>">Home</a></li>
    <?php foreach (Yii::$app->menu->current->teardown as $item): ?>
       <li><a href="<?= $item->link; ?>"><?= $item->title; ?></a></li>
    <?php endforeach; ?>
</ol>
```

## Menu Levels

Sometimes you have navigation which should stick based on the previous item, assuming you have 2 menus, one on the top and the other on the left side, in order to display the second menu based on the current active menu you can use {{luya\cms\Menu::getLevelContainer}}.

```php
// you print the first menu somewhere:
foreach (Yii::$app->menu->find()->where(['container' => 'default', 'parent_nav_id' => 0])->all() as $item):
    echo $item->title;
endforeach;

// but have a second menu based on the first menu somewhere else:
foreach (Yii::$app->menu->getLevelContainer(2) as $secondItem):
    echo $secondItem->title;
endforeach; 
```

# Menu Item Injection

There is also a possibility to inject data into the menu component direct from every part of your web application. An item inject gives a module the possibility to add items into the menu Container.

The most important propertie of the injectItem clas is the `childOf` definition, this is where you have to define who is the parent *nav_item.id*. An item inject contain be done during the eventAfterLoad event to attach at the right initializer moment of the item, but could be done any time. To inject an item use the {{\luya\cms\Menu::injectItem}} method on the menu Container like below:

```php
Yii::$app->menu->injectItem(new InjectItem([
    'childOf' => 123,
    'title' => 'This is the inject title',
    'alias' => 'this-is-the-inject-alias',
]));
```

To attach the item at right moment you can bootstrap your module and use the `eventAfterLoad` event of the menu component:

```php
Yii::$app->menu->on(Container::MENU_AFTER_LOAD, function($event) {

    $newItem = new InjectItem([
        'childOf' => 123,
        'title' => 'Inject Title',
        'alias' => 'inject-title',
    ]);

    $event->sender->injectItem($newItem);
});
```
