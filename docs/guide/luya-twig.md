Twig functions
==============

the following twig functions are available in all twig ***frontend*** templates. Not in in block twigAdmin, cause they are rendere with twig.js:

### Functions

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
|t                  |`t('app', 'bar')`  |Twig wrapper für `Yii::t('app', 'bar')` in [Übersetzungen](app-translation.md).

### Variables

|Variabel          |Ausgabe
|---               |---
|publicHtml        |Gibt den aktuellen Pfad für dateien und Bilder zurück [getPublicHtml()](https://luya.io/api/luya-web-view.html#getPublicHtml()-detail)


links
-----
wrapper functions for the luya links component findByArguments function. Will return an array of links for the defined method arguments:

```
{% for item in links('cat', 'lang', 'parent_nav_id') %}
	{{ dump(item) }}
{% endfor %}
```

The below example returns an array containing all links for ***cat => default***, ***language => de*** and ***parent_nav_id =>  0***:

```
{{ dump(links('default', 'de', 0)) }}
```

To get the first sub navigation of current active page node just add the dynamic parent_nav_id

```
{{ dump(links('default', 'de', activeUrl.id)) }}
```

The variable activeUrl returns an array containing informations about the current active link.


linksFindParent
---------------
find the parent navigation id for the current active navigation link for a specific level:

```
parent level 1 for active link: {{ linksFindParent(1) }}
parent level 2 for active link: {{ linksFindParent(2) }}
parent level 3 for active link: {{ linksFindParent(3) }}
```

linkActivePart
---------------
get the current active link part where 0 is the first menu part.

```
{{ linkActivePart(0) }}
```

asset
-----
Get the bundle object from an asset class

```
<p>{{ asset('\\my\\project\\Asset') }}</p>
```

(error cause of object to string conversion, use dump() twig function to look inside the object.)

Real world example for accessing baseUrl:

```
<img src="{{ asset('\\app\\assets\\ResourcesAsset').baseUrl }}/img/asset.jpg" />
```

filterApply
-----------
Get the image source (absolut image path) based on imageId and filterIdentifier

```
<img src="{{ filterApply(my_image_id_from_item, 'my_custom_filter') }}" />
```

image
------
Get an image object from an existing imageId:

```
<img src="{{ image(my_image_id_from_item).source }}" />
```
