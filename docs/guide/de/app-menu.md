Layout Menu
===========

> `links` ist seit 1.0.0-beta1 deprecated, anstelle wird `menu` verwendet.

Menu Component

**Query menu data**

ability to add multiple querys as "AND" chain. like below: parent_nav_id = 0 AND parent_nav_id = 1

```php
foreach(Yii::$app->menu->find()->where(['parent_nav_id' => 0, 'parent_nav_id' => 1])->all() as $item) {
    echo $item->title;
}
```

Find one item:

```php
$item = Yii::$app->menu->find()->where(['id' => 1])->one();
```

If the element coult nod be found, one will return *false*.

**Getter methods of an item**

```php
$item->getTitle();
$item->getLink();
$item->getAlias();
$item->getChildren();
$item->getParent();
$item->teardown();
```

All getter methods can be access like

```php
$item->title;
$item->link;
$item->alias;
$item->childeren;
$item->parent;
```

Get current active Item

```php
$item = Yii::$app->menu->getCurrent();
```

as of getter

```php
$item = Yii::$app->menu->current;
```

Get home item

```php
$item = Yii::$app->menu->getHome();
```

as of getter

```php
$item = Yii::$app->menu->home;
```

Sprachen (composition)
----------------------
Zusätzlich zur Link-Komponente wird die `composition` Komponente gebraucht. Sie gibt Auskunft über die aktuellen Sprachen und den Umgebungszustand. Die Composition Pattern Komponente kann definiert werden (@TBD). Sie können mit `Yii::$app->composition` auf die Composition Komponente zugreifen. Um Daten auszulesen verwenden Sie die `getKey()` Methode. Um auf den aktuelle Sprachcode zuzugreifen verwenden Sie:

> seite 1.0.0-beta1 verfügt die composition component ein array access und daten können anstellevon `$composition->geyKey('keyName')` via `$compositon['keyName']` aufgerufen werden.

```php
$langShortCode = Yii::$app->composition['langShortCode'];
```

Wenn Sie den aktuell ausgefüllten Composition Pattern erhalten möchten, können Sie dies mit `getFull()` tun:

```
echo Yii::$app->composition->full;
```

Links zu Seiten im CMS
---------------------

Um innerhalb des CMS oder eines Modules einen Link zu einer internen Seite zu machen verwenden Sie die folgenden Markdown-ähnlichen einweisungen:

```html
link[3](Alternativer Link Name)

<!-- Output: <a href="url/to/3">Alternativer Link Name</a> -->
```

wobei *3* die Nummer der Seite ist. Wenn kein alternativer link name angegeben wird, wird autoamtisch der Seiten Titel aus dem CMS eingefügt.

```html
link[3]

<!-- Output: <a href="url/to/3">Name of 3</a> -->
```

Man kann auch statische Links erzeugen

```html
link[www.luya.io]

<!-- Output: <a href="http://www.luya.io">luya.io</a> -->
```

> Ein fehlendes http:// wird automatisch angefügt.

Mit Alternativen Label

```html
link[luya.io](Hier gehts zur Doku)

<!-- Output: <a href="http://luya.io">Hier gehts zur Doku</a> -->
```
