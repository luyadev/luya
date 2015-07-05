Frontend Modul
==============
Ein *Frontend* Modul kann direkt views rendern und daten aus modellen ausgeben. Um ein Modul aufzurufen öffnen sprechen Sie das Module im Browser direkt mit deren namen an `http://localhost/meinprojekt/meinmodul` oder wenn man sich im CMS Context bewegt ein Module-Block hinzufügen.

Views
------
Ein Modul kann via `$useAppLayoutPath` entscheiden ob alle views *isoliert* im Modul liegen sollen oder alle views im Views Ordner des Projekts liegen sollen also *shared*. Die isolierte Methode kann verwendet werden wenn ein Modul die komplette kontrolle und unabhängig eines Projekts verwendet werden soll. Alle Daten werden somit gelifert und der Benutzer muss keine Zeit in tempaltes mehr investieren. Dies kann zum Beispiel bei einer komplexen Kalender ansicht verwenden werden wobei das Look und Feel via CSS geregelt wird. Standardmässig wird die *shared* Methode verwendet (`$useAppLayoutPath = true`). Die `$useAppLayoutPath` können Sie in der `Module.php` Datei als Klassen eigeschanft definieren.
```php
<?php
namespace app\modules\team;

class Module extends \luya\base\Module
{
    public $useAppLayoutPath = false; // nun werden die views im Modul Ordner gesucht
}
```

> Die `$useAppLayoutPath` eigenschaft sollte nur in Frontend Modulen verwendet werden.

Controllers
-----------
Wenn Sie einen Controller im CMS Content verwenden möchten um zusätzliche Meta infos zu setzen, abstrahieren Sie von `luya\base\PageController` anstelle von `luya\base\Controller`.

Layouts
-------
Alle views welche mit `$this->render()` verarbeitet werden inkludieren das layout welches in `views/layouts/main.php` liegt. Wer nun aber inerhalb des Modules einen *Layout ähnlichen* view rendenr möchte kann dies mit `$this->renderLayout()` bezwecken. Warum nicht `$this->render` verwenden? 
+ `renderLayout()` verwendet einen klar definieren view namen welcher verwendet werden muss.
+ konsequents verhalten innerhalb eines Controllers.

Als Parameter für `renderLayout()` verwenden Sie ein array, wobei der key einer Variabel entspricht und value dem Inhalt. Wenn Sie eine variabel benötigen, wie `$content` muss diese überall bei wiederverwendung von renderLayout innerhalb dieses Moduls angegene werden. (Alternativ können Sie `$context` verwenden. Sie nächste Sektion).

### Beispiel
Abstrakte Klasse `modules/estore/base/Controller.php`:
```php
<?php
namespace app\modules\estore\base;

abstract class EstoreController extends \luya\base\PageController
{
    public function getBasketTotal()
    {
        return [
            'currency' => 'CHF',
            'amount' => '20.00',
        ];
    }
}
```

Controller-Datei `modules/estore/controllers/DefaultController.php`:
```php
<?php
namespace app\modules\estore\controllers;

class DefaultController extends \app\modules\estore\base\Controller
{
    public function actionIndex()
    {
        return $this->renderLayout([
            "content" => $this->renderPartial('_index')  
        ]);        
    }
    
    public function actionBasket()
    {   
        return $this->renderLayout([
            "content" => $this->renderPartial('_basket')        
        ]);
    }
}
```

Jetzt können Sie in beiden `renderPartial` views auf die Funktion `$this->context->getBasketTotal` zugreifen unabhängig von Ihrere Controller Logik.

Context
-------
Die verwendung der `$context` variabel innerhalb eines views kann sehr effektiv sein bei *vielen controllern* und views. Wenn Sie eine *public* methode in einen Controller implenetieren, zbsp. `public function getBasketTotal()` kann diese Funktione innerhalb des views mit `$this->context->getBasketTotal()` aufgerufen werden. Wenn Sie nun eine `abstract` Controlle erstellen und diesen als `extends` benutzen so können Sie diese abstrahiert controller logik in allen views wieder verwenden.

Url-Rules/Url-Regel (Lesbare Urls)
--------------------------
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

Um die Lesbare Url innerhalb eines `views` zu erstellen verwenden Sie `luya\helpers\Url::to` wie folgt `\luya\helpers\Url::to('estore/basket/index');`.

Sie können auch Parameter innerhalb der Regel definieren, ein Beispiel für einen Artikel innerhalb des Estores:
```php
['pattern' => 'artikel/<id:\d+>', 'route' => 'estore/article/index'],
```

Um einen Parameter anzugeben bei erstellen einer Url verwenden Sie das Arguments Array der Url::to helper funktion `\luya\helpers\Url::to('estore/article/index', ['id' => 7]);`.

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