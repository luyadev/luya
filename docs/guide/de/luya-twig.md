Twig in Luya
-------------
In verschiedenen Teilen von *LUYA* werden *Twig Templates* verwendet. Für

+ Blöcke (Frontend)
+ Cms Layouts

werden die Twig Templates mit der endung `*.twig` verwendeten views gerendet. Um verschiedene Komponenten wie der [Links Komponenten um Navigation zu erstellen](app-links.md) oder [Projekte Asset Daten](app-assets.md) abzugreifen wurden speziele *Twig Funktionen* integriert. Hier eine Basis verwendungs übersicht von Twig:

```twig
{% if vars.foo not null%}<p>{{ vars.foo }}</p>{% endif %} 
```

> Um eine Ausgabe zu testen können sie `dump(__FUNKTION__)` ausführen.

### Funktionen

|Funktion           |Beispiel        |Beschreibung      
|--------           |------------    |------------
|menuFindOne        |`menuFindOne(1)` |Findet einen Menu eintrag für die angegeben Nav-Item-id (kurz id).
|menuCurrent        |`menuCurrent()`    |Gibt das aktuelle menue element zurück. Dies beinhaltet ein [Item-Object](https://luya.io/api/cms-menu-item.html).
|menuCurrentLevel   |`menuCurrentLevel(1)`  |Gibt das aktuelle menu item zurück für das angegeben level, die Level Angaben starten bei 1.
|menuFindAll        |`menuFindAll('container-alias', 0)` |Gibt alle menu element für den definieren Menu Container und die angegeben parent_nav_id (hier 0) an.
|asset              |`asset('\\my\\project\\Asset')` |Gibt das Klassen Objekt für eine Asset Klasse zurück. `false` falls nicht gefunden.
|image              |`image(123)` |Gibt das aktuelle Bild objekt für die angebgeben ID zurück. `false` falls nicht gefunden.
|filterApply        |`filterApply(123, 'my-filter-to-apply')` |Wendet einen Filter auf ein Bild an (falls dieser noch nicht angwendet wurde) und gibt den aboslute Bildpfad zurück des neue generierteen Bildes.
|element            |`element('button','arg1','arg2')` |Ruf das Html Element `button` auf mit den Paramteren `arg1` und `arg2`.
|t		            |`t('app', 'bar')`  |Twig wrapper für `Yii::t('app', 'bar')` in [Übersetzungen](app-translation.md).

### Variabeln

|Variabel          |Ausgabe
|---               |---
|publicHtml        |Gibt den aktuellen Pfad für dateien und Bilder zurück [getPublicHtml()](https://luya.io/api/luya-web-view.html#getPublicHtml()-detail)



Links Komponente für Navigationen
----------------------------------
Die `Yii::$app->menu->findAll(['container' => $container, 'parent_nav_id' => $parentNavId])->all();` methode kann durch die twig funktion `menuFindAll` verwendent werden wobei Paremeter 1 für `$container` und Paremeter 2 für `$parentNavId` stehen.

```twig
{% for item in menuFindAll($container, $parentNavId) %}
    {{ dump(item) }}
{% endfor %}
```

Hier ein Beispiel mit *Navigations Container* = `default` und *Parent Navigation Id* = `0`:

```
{{ dump(links('default', 0)) }}
```

Erster *Sub-Navigation* eintrag für die aktuelle aktive Seite:

```
{{ dump(links('default', menuCurrent.navId )) }}
```

Assets
-------
Gibt eine Asset Bundle anhand der Asset Klasse zurück und `false` wenn es nicht gefunden werden kontte.

```
<p>{{ asset('\\my\\project\\Asset') }}</p>
```

> Um ein Asset zu debuggen benutzen Sie `dump(asset('\\my\\project\\Asset'))`

Die `baseUrl` für ein Bild innerhlab des assets ausgeben:

```
<img src="{{ asset('\\app\\assets\\ResourcesAsset').baseUrl }}/img/asset.jpg" />
```

