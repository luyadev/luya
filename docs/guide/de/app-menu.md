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
Zusätzlich zur Link-Komponente wird die `composition` Komponente gebraucht. Sie gibt Auskunft über die aktuellen Sprachen und den Umgebungszustand. Die Composition Pattern Komponente kann definiert werden (@TBD). Du kannst mit `Yii::$app->composition` auf die Composition Komponente zugreifen. Um Daten auszulesen verwendest du die `getKey()` Methode. Um auf den aktuelle Sprachcode zuzugreifen verwenden Sie:

> seite 1.0.0-beta1 verfügt die composition component ein array access und daten können anstelle von `$composition->geyKey('keyName')` via `$compositon['keyName']` aufgerufen werden.

```php
$langShortCode = Yii::$app->composition['langShortCode'];
```

Wenn du den aktuell ausgefüllten Composition Pattern erhalten möchtest, kannst du dies mit `getFull()` tun:

```
echo Yii::$app->composition->full;
```

Links zu Seiten im CMS
---------------------

Um innerhalb des CMS oder eines Modules einen Link zu einer internen Seite zu machen verwendest du die folgenden, Markdown-ähnlichen Einweisungen:

|Link Syntax        |Html Ausgabe
|----               |----
|`link [3] (Alternativer Link Name)`  |`<a href="url/to/3">Alternativer Link Name</a>`
|`link [3]`                           |`<a href="url/to/3">Name of 3</a>`
|`link [www.luya.io]`                 |`<a href="http://www.luya.io">luya.io</a>`
|`link [luya.io] (Hier gehts zur Doku)` |`<a href="http://luya.io">Hier gehts zur Doku</a>`

**ACHTUNG:** Die oben genannten *Link Syntax* müssen **ohne** Leerzeichen zwischen den einzelnen Gruppierungen sein damit die link syntaxe funktionieren.

> Beispiele mit der Zahl 3: Die Zahl 3 entspricht der Seiten-Id welche erscheint wenn man mit dem Maus-Cursor über dem Seitenbaum einer besteimmten Seite fährt.

![Seiten ID](https://raw.githubusercontent.com/zephir/luya/master/docs/guide/img/cms-nav-page-id.jpg "Seiten ID")

> Ein fehlendes http:// wird bei statischen links automatisch angefügt.