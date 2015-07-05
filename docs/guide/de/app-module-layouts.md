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
