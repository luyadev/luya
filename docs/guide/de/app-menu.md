Layout Menu
===========
Um ein Navigation oder Subnavigation innerhalb eins layouts (oder cmslayouts) zu erstellen benötigen Sie die `$app->links` Komponent welche vom CMS-Modul zur Verfügung gestellt wird.

> Tipp: Die Links component wird meistens am start der `main.php` als variabel `$links` hinterlegt `$links = Yii::$app->links;`.

Das Links Komponent Objekt biete eine mächte Funktione names `findByArguemnts()` wobei die argument der Methode eine Array entsprechen müssen. Vergleichs Operatoren für die `findByArguments` methode stehen folgende key zur Verfügung:

| Key | Beschreibung | 
| --- | ------------ | 
| url | gesamt url mit unter pfadelementen
| rewrite | entsprich dem Pfadsegment im CMS Admin
| id | Id numerisch ID aus der Dantebk
| parent_nav_id | Die der vorher gehenden Seite
| nav_item_id | Die Id welche eindeugit ist für den key mit der sprache
| title | Den Seiten Titel
| lang | Den Sprachen short_code (zbsp. de, en, etc.)
| lang_id | Die Sprachen ID aus der Datenabk
| cat | Die cateogrie rewrite (zbsp. default)
| depth | den z-index der Seite (0 = höchster index)

Sie können nun zum Beispiel alle Seiten auf dem Root level ausgeben.
```php
$links = Yii::$app->links;
$menu = $links->findByArguemnts(['parent_nav_id' => 0]);
foreach($menu as $item) {
    var_dump($item);
}
```
> Die Ausgabe ist IMMER ein array. Wenn Sie einen einzelen Eintrag möchten können Sie `FindOneByArguments()` verwenden.

Sie können auch mehrer Argumente verbinden. Wenn Wir nunr alle elemente auf dem Root Level wollen für die Sprache 'de':
```php
$menu = $links->findByArguemnt(['parent_nav_id' => 0, 'lang' => 'de']);
```

Wenn Sie den aktuell **aktiven Link** ausgeben möchten verwenden Sie:
```php
echo Yii::$app->links->activeLink;
```

Sprachen (composition)
----------------------
Zusätlich zur links komponent wird die `composition` komponent gebaucht. Sie gibt Auskunft über den aktuelle Sprachen und Umgebungs Zustand. Die composition pattern komponente kann definiert werden (@TBD). Sie können mit `Yii::$app->composition` auf die composition Komponente zugreifen. Um Daten auszulesen verwenden Sie die `getKey()` methode. Um auf den aktuelle Sprachcode zuzugreifen verwenden Sie:
```php
$langShortCode = Yii::$app->composition->getKey('langShortCode');
```
Wenn Sie den aktuelle ausgefüllte composition pattern erhalten möchten, können Sie dies mit `getFull()` tun:
```
echo Yii::$app->composition->getFull();
```
> Tipp: Erstellen sie eine `$composition` Variabel am anfang ihres main.php layouts um sich wiederholung zu ersparen. `$composition = Yii::$app->composition;`

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