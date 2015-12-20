Menu Navigation
===========

> `links` ist seit 1.0.0-beta1 deprecated, anstelle wird `menu` verwendet.

Wie erstelle ich eine Navigation für meine Seite? Wie kann man ein Footer/Meta Menu erstellen? Wie gebe ich den aktuelle link aus? Wie gehe ich mit den verschiedenen Navigations Typen um? Die Menu Komponente ist ein Datebank ähnlicher Container welcher alle nötigen Informationen gemäss deinem wunsch anzeigt.

Die Menu Componente (Oder auch MenuContainer) kann via `Yii::$app->menu` aufgerufen werden. Jeder Eintrag aus der Menu Komponenten gibt ein [Menu-Item-Object](https://luya.io/api/cms-menu-item.html). Alle Getter methoden zbsp `$itemObject->getLink()` können direkt als `$itemObject->link` aufgerufen werden. Das wird durch die Yii base object implementation gewährleistet.

Aktuelle Seite ausgeben
----------------------

Eines der wichtigtes features der menu componente ist das ausgeben und erkenne der aktuellen seite auf welcher du dich aktuell befindest. Dies wird über die Methode `getCurrent()` ausgegeben. Diese methode liefert dir wieder ein Menu-Item-Object zurück.

Ausgeben des aktuelle Links:

```php
echo Yii::$app->menu->current->link;
```

dies entspricht auch dem klassischem wegem der get methoden. Wir empfehlen aber die shortform variante welche oben stehtn.

```php
echo Yii::$app->menu->getCurrent()->getLink();
```

Startseite ausgeben
------------------

Die aktuelle home seite kann über die helper methode `getHome()` aufgerufen werden, somit könnten man zbsp. der Titel der Home sete wei folgt anzeigen

```php
echo Yii::$app->menu->home->title;
```

Menu Auslesen
-------------

Das auslesen von menu Daten mit bestimmten optionen operiert über die `find()` methode. Hier ein beispiel für das ausgeben aller menu einträge auf der ersten eben:

```php
foreach(Yii::$app->menu->find()->where(['parent_nav_id' => 0])->all() as $itemObject) {
    var_dump($itemObject);
}
```

Das oben gezeigt beispiel findet alle daten wie folgt als sql ähnlicher snytax ausgedrückt: `WHERE parent_nav_id = 0`. Um mehrer bedingunge anzuknöpfen 

```
foreach(Yii::$app->menu->find()->where(['parent_nav_id' => 0, 'is_active' => 1])->all() as $itemObject) {
    var_dump($itemObject);
}
```

Dies entspricht einer and where bedingung ähnlichen sql syntax: `WHERE parent_nav_id = 0 AND is_active = 1`. Um bedingungen auszuführen welche nicht immer eine AND verknlüpfung entsprechen kann man einen array ausdruck verwenden:

```php
where(['!=', 'is_active', 0])->andWhere(['==', 'parent_nav_id', 0]); // WHERE is_active != AND parent_nav_id === 0
```

|Operatoren |Entspricht
|---|---
|<= | Kleiner als und aktueller Wert
|<  | Kleiner als
|>  | Grösser als
|>= | Grösser als und aktueller Wert
|=  | Entspricht
|== | Entspricht mit Typen vergleich.

Breadcrumbs ausgeben
--------------------

Um zum beispiel die breadcrumbs der aktuellen Seite ausgzugeben kann die Item-Object-Method `getTeardown()` zbsp. wie folg verwendet werden.

```php
foreach(Yii::$app->menu->current->teardown as $item) {
    echo '<li><a href="' . $item->link . '">' . $item->title . '</a></li>';
}
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