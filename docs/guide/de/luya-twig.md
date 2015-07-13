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

| Funktion        | Beispiel        |  Beschreibung      
| --------        | ------------    | ------------
| links           | `links('cat', 'lang', 'parent_nav_id')` | Eine Wrapper funktione für `Yii::$app->links->findByArgument mit `['cat' => '%cat', 'lang' => '%lang', 'parent_nav_id' => '%parent_nav_id']`.
| linksFindParent | `linksFindParent(1)` | Gib den parent eitnrag ein für das aktuelle level `1`.
| linkActivePart    | `linkActivePart(1)` | Gibt die den aktuellen Link für das Menu Level aus `1`.
| asset             | `asset('\\my\\project\\Asset')` | Gibt das Klassen Objekt für eine Asset Klasse zurück. `false` falls nicht gefunden.
| image             | `image(123)` | Gibt das aktuelle Bild objekt für die angebgeben ID zurück. `false` falls nicht gefunden.
| filterApply       | `filterApply(123, 'my-filter-to-apply')` | Wendet einen Filter auf ein Bild an (falls dieser noch nicht angwendet wurde) und gibt den aboslute Bildpfad zurück des neue generierteen Bildes.

### Variabeln

| Variabel          | Ausgabe
| ---               | ---
| activeUrl         | Gibt ein array mit dem aktuellen Navigations eintrag zurück.



Links Komponente für Navigationen
----------------------------------
Die `Yii::$app->links->findByArguemnts()` methode kann durch die twig funktion `links` verwendent werden wobei 3 Paremeter `cat`, `lang` und `parent_nav_id` entsprechen, in dieser Reienfolge.

```twig
{% for item in links('cat', 'lang', 'parent_nav_id') %}
    {{ dump(item) }}
{% endfor %}
```

Hier ein beispiel mit *Navigations Container* = `default`, *Sprache* = `de` und *Parent Navigations Id* = `0`:

```
{{ dump(links('default', 'de', 0)) }}
```

Erster *Sub-Navigation* eintrag für die aktuelle aktive Seite:

```
{{ dump(links('default', 'de', activeUrl.id)) }}
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

