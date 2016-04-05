Layouts
-------
Alle views welche mit `$this->render($viewFile)` verarbeitet werden inkludieren das layout welches in `views/layouts/main.php` liegt. Wer nun aber inerhalb des Modules einen *Layout ähnlichen* view rendenr möchte kann dies mit `$this->renderLayout($viewFile)` bezwecken. Warum nicht `$this->render($viewFile)` verwenden? 

+ `renderLayout($viewFile)` verwendet einen klar definieren view namen welcher verwendet werden muss.
+ die Variabeln `$content` entspricht dem inhalt des angegeben `$viewFile`.

Als Parameter für `renderLayout()` verwenden Sie ein array, wobei der key einer Variabel entspricht und value dem Inhalt. Wenn Sie eine variabel benötigen, wie `$content` muss diese überall bei wiederverwendung von renderLayout innerhalb dieses Moduls angegene werden. (Alternativ können Sie `$context` verwenden. Sie nächste Sektion).

### Beispiel
Abstrakte Klasse `modules/estore/base/Controller.php`:

```php
<?php
namespace app\modules\estore\base;

abstract class EstoreController extends \luya\web\Controller
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
        return $this->renderLayout('index');        
    }
    
    public function actionBasket()
    {   
        return $this->renderLayout('basket');
    }
}
```

Jetzt können Sie in beiden `renderPartial` views auf die Funktion `$this->context->getBasketTotal` zugreifen unabhängig von Ihrere Controller Logik.
