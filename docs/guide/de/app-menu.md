Layout Menu
===========
Um eine Navigation oder Subnavigation innerhalb eines Layouts (oder cmsLayouts) zu erstellen benötigen Sie die `$app->links` Komponente, welche vom CMS-Modul zur Verfügung gestellt wird.

> Tipp: Die Links Component wird meistens am Start der `main.php` als Variable `$links` hinterlegt `$links = Yii::$app->links;`.

Das Links Komponentenobjekt bietet die mächtige Funktion `findByArguemnts()`, wobei die Argumente der Methode einem Array entsprechen müssen. Vergleichsoperatoren für die `findByArguments` Methode stehen folgende Keys zur Verfügung:

| Key | Beschreibung | 
| --- | ------------ | 
| full_url | Gesame URL inklusive der **aktuellen** sprache, nicht die Sprache der Seite
| url | Gesamt URL mit unteren Pfadelementen
| rewrite | Entspricht dem Pfadsegment im CMS Admin
| nav_id | numerische ID aus der Datenbank der *nav* Tabelle
| parent_nav_id | Die der vorher gehenden Seite
| id | Die Id welche eindeutig ist für den Key mit der Sprache also die Tabelle *nav_item*
| title | Den Seiten Titel
| lang | Den Sprachen short_code (zbsp. de, en, etc.)
| lang_id | Die Sprachen ID aus der Datenbank
| cat | Die Categorie rewrite (z.B. default)
| depth | Den z-index der Seite (0 = höchster index)

Sie können nun zum Beispiel alle Seiten auf dem Root Level ausgeben.

```php
$links = Yii::$app->links;
$menu = $links->findByArguemnts(['parent_nav_id' => 0]);
foreach($menu as $item) {
    var_dump($item);
}
```

> Die Ausgabe ist IMMER ein Array. Wenn Sie einen einzelnen Eintrag möchten, können Sie `FindOneByArguments()` verwenden.

Sie können auch mehrere Argumente verbinden. Wenn wir nun alle Elemente auf dem Root Level für die Sprache 'de' wollen :

```php
$menu = $links->findByArguemnt(['parent_nav_id' => 0, 'lang' => 'de']);
```

Wenn Sie die aktuelle Url ausgeben möchten verwenden Sie:

```php
echo Yii::$app->links->activeUrl;
```


Sprachen (composition)
----------------------
Zusätzlich zur Link-Komponente wird die `composition` Komponente gebraucht. Sie gibt Auskunft über die aktuellen Sprachen und den Umgebungszustand. Die Composition Pattern Komponente kann definiert werden (@TBD). Sie können mit `Yii::$app->composition` auf die Composition Komponente zugreifen. Um Daten auszulesen verwenden Sie die `getKey()` Methode. Um auf den aktuelle Sprachcode zuzugreifen verwenden Sie:

```php
$langShortCode = Yii::$app->composition->getKey('langShortCode');
```

Wenn Sie den aktuell ausgefüllten Composition Pattern erhalten möchten, können Sie dies mit `getFull()` tun:

```
echo Yii::$app->composition->getFull();
```

> Tipp: Erstellen sie eine `$composition` Variabel am Anfang ihres main.php Layouts um sich Wiederholung zu ersparen. `$composition = Yii::$app->composition;`

Mehrteilige Navigation
----------------------

```php
<ul>
<? foreach(Yii::$app->links->findByArguments(['cat' => 'default', 'lang' => $composition->langShortCode, 'parent_nav_id' => 0]) as $item): ?>
        <li><a href="<?= $composition->getFull() . $item['url'];?>"><?= $item['title']; ?></a>
            <ul>
                <? foreach(Yii::$app->links->findByArguments(['lang' => $composition->langShortCode, 'parent_nav_id' => $item['id']]) as $subItem): ?>
                <li><a href="<?= $composition->getFull() . $subItem['url'];?>"><?= $subItem['title']?></a>
                <ul>
                    <? foreach(Yii::$app->links->findByArguments(['lang' => $composition->langShortCode, 'parent_nav_id' => $subItem['id']]) as $subSubItem): ?>
                    <li><a href="<?= $composition->getFull() . $subSubItem['url'];?>"><?= $subSubItem['title']?></a>
                    <? endforeach; ?>
                </ul>
                <? endforeach; ?>
            </ul>
        </li>
    <? endforeach; ?>
</ul>
```

Geteilte Navigationen
---------------------

```php
<!-- FIRST LEVEL -->
<ul>
    <? foreach(Yii::$app->links->findByArguments(['cat' => 'default', 'lang' => $composition->langShortCode, 'parent_nav_id' => \luya\helpers\Menu::parentNavIdByCurrentLink(\yii::$app->links, 1)]) as $item): ?>
        <li><a href="<?= $composition->getFull() . $item['url'];?>"><?= $item['title']; ?></a></li>
    <? endforeach; ?>
</ul>

<!-- SECOND LEVEL -->
<ul>
    <? foreach(Yii::$app->links->findByArguments(['cat' => 'default', 'lang' => $composition->langShortCode, 'parent_nav_id' => \luya\helpers\Menu::parentNavIdByCurrentLink(\yii::$app->links, 2)]) as $item): ?>
        <li><a href="<?= $composition->getFull() . $item['url'];?>"><?= $item['title']; ?></a></li>
    <? endforeach; ?>
</ul>

<!-- THIRD LEVEL -->
 <ul>
    <? foreach(Yii::$app->links->findByArguments(['cat' => 'default', 'lang' => $composition->langShortCode, 'parent_nav_id' => \luya\helpers\Menu::parentNavIdByCurrentLink(\yii::$app->links, 3)]) as $item): ?>
        <li><a href="<?= $composition->getFull() . $item['url'];?>"><?= $item['title']; ?></a></li>
    <? endforeach; ?>
</ul>
``` 
