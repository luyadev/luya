moduleLayout
------------

use 
```php
$this->renderLayout([

]]); 
```

to render a fake like layout inside modules


EXAMPLE
=======
controllers/DefaultController.php
```php
namespace app\modules\estore\controllers;

class DefaultController extends \app\modules\estore\base\EstoreController
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
base/EstoreController.php
```php
namespace app\modules\estore\base;

class EstoreController extends \luya\base\PageController
{
    public function getBasketTotal()
    {
        return [
            'items' => 10,
            'acmount' => '20.50 CHF'
        ];
    }
}
```

@app/views/estore/moduleLayout.php
```php
estore header
<hr />
<?php echo $content; ?>
<hr />
estore footer
<?php  print_r($this->context->getBasketTotal());?>