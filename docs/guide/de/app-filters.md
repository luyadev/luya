Projekt Filter
=============
Mit einem Projekt Filter kannst du *Bilder* nach deinen Projekt spezifischen bedürfnissen verarbeiten (Zuscheiden, Verkleinern, Thumbnail). Wenn du einen neuen Projekt-Filter erstellst kann dieser mit dem cli command `exec` eingelesen werden.

> Die idee hinter den Klassen für die Filter liegt darin alle Daten via Version-Kontroller zu tracken. Somit verfügst du und dein Projekt-Kameraden immer über die selben Einstellungen.

Beispiel Filter
---------------
Um einen Filter zu erstellen gehst du in deinem Projekt (app) in den Ordner `filters`, falls dieser nicht existiert kannst du ihn erstellen. Erstelle nun eine PHP Datei mit suffix *Filter*, zum Beispiel `MyFilter`. Der Inhalt dieser Datei könnte wie folgt aussehen:

```php
<?php

namespace app\filters;

class MyFilter extends \admin\base\Filter
{    
    public function identifier()
    {
        return 'my-filter';
    }
    
    public function name()
    {
        return 'my App Filter';
    }
    
    public function chain()
    {
        return [
            [self::EFFECT_THUMBNAIL, [
                'width' => 100,
                'height' => 100,
            ]],
        ];
    }
}
```

In der `chain()` methode kannst du mehrer verschieden Effekt hintereinander reihen, eine Übersicht aller effekt findest du unter **Admin->Effects**. Den soeben erstellten `MyFilter` kannst du nun mit dem `import`-Befehl ([Konsolenbefehle](luya-console.md)) importieren.

Filter Anwenden
----------------
Um diesen erstellen Filter in einem PHP-View oder Twig-File anzuwenden kannst du auf die `storage` component zugreifen. Hier ein bespiel in einem PHP View:

```php
<img src="<?= yii::$app->storage->image->filterApply(139, 'my-filter'); ?>" border="0" />
```

Wobei natürlich **139** die Bild-Id ist welche wahrscheinlich aus der Datenbank kommt (zbsp. News Bild). In einem *Foreach-Loop* könnte dies so aussehen:

```php
<? foreach($newsData as $item): ?>
    <img src="<?= yii::$app->storage->image->filterApply($item['imageId'], 'my-filter'); ?>" border="0" />
<? endforeach; ?>
```

> Die Bild sources sollten immer in der Controller-Logik geprüft werden!

Wenn du ein Bild in einem Twig file rendenr möchtest kannst du die Twig funktion `filterApply` verwenden. Dies kann zbsp. in einem CMS-Layout der Fall sein.

```
<img src="{{ filterApply(139, 'my-filter') }}" />
```