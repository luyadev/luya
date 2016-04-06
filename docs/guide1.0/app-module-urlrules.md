Url-Rules/Url-Regel (Lesbare Urls)
--------------------------

> TO BE TRANSLATED

Um eine neue *Url-Rule* (Regel) zu defnieren gehen Sie in die `Module.php` Datei 
des Moduls und fügen Sie eine neuen eigenschaft(property) `public $urlRules` mit einem Leeren Array `= []` hinzu. Um eine neue Regel zu erstellen müssen Sie ein Array Element erstellen und dies keys *pattern* und *route" definieren.

| Variabel Name     | Beschreibung
| --------------    | ------------
| pattern           | Den Wert der Adresse den Sie *neu* erzeugen möchten und für die Endbenutzer ersichtlich ist.
| route             | Wohin soll die neue Adresse-Intern geleitet werden. Welche Url-Route (module/controller/action) soll geöffnet werden.

### Beispiel 

Die `Module.php` Datei um die Regel erweitern:

```php
<?php
namespace app\modules\team;

class Module extends \luya\base\Module
{
    public $urlRules = [
        ['pattern' => 'warenkorb', 'route' => 'estore/basket/index']
    ];
}
```

Die Adresse `warenkorb` würde nun die Aktion `actionIndex` in `BasektController` innerhalb des Modules `estore` öffnen und zurück geben.

Um die Lesbare Url innerhalb eines `views` zu erstellen verwenden Sie `luya\helpers\Url::toManager` wie folgt `\luya\helpers\Url::toManager('estore/basket/index');`.

Sie können auch Parameter innerhalb der Regel definieren, ein Beispiel für einen Artikel innerhalb des Estores:

```php
['pattern' => 'artikel/<id:\d+>', 'route' => 'estore/article/index'],
```

Um einen Parameter anzugeben bei erstellen einer Url verwenden Sie das Arguments Array der Url::toManager helper funktion:

```
\luya\helpers\Url::toManager('estore/article/index', ['id' => 7]);
```

Die selbe funktion würde mit dem toRoute helper von Yii wie folgt aussehen:

```
\luya\helpers\Url::toRoute(['/estore/article/index', 'id' => 7]);
```

> Url Regel sollten immer den Modul prefix enthalten um innerhalb des CMS Context keine gleichnamigen URLS zu erhalten.

### Mehrspachige URLs
Um eine URL regel für bestimmte [Compositions](app-menu.md) pattern zu hinterlegen fügen Sie den `composition` key zur Regel hinzu, das array innerhalb der composition kann den *pattern* key für für die entsprechenden composition überschreiben. Wenn keine composition auf die aktuelle Situation zutrifft wird der default Wert in `pattern` verwendet. Ein Biespiel:

```php
public $urlRules = [
    ['pattern' => 'estore/warenkorb', 'route' => 'estore/basket/default', 'composition' => 
        [
            'fr' => 'estore/panier',
            'en' => 'estore/basket'
        ]
    ],
];
```

Wenn nun `Yii::$app->composition->getFull()` dem Wert *fr* entsprich wird der Pattern Wert `estore/panier` anstelle von `estore/warenkorb` verwendet.