creating a frontend module
==========================

$useAppLayoutPath
-----------------------

Choose if you want to load your layout from the project path (@app) or directly from your module. 

```php
public $useAppLayoutPath = true;
```
default is true.


$urlRules
---------
Adding url rules

```
    public static $urlRules = [
        ['pattern' => 'estore/warenkorb', 'route' => 'estore/default/basket'],
        ['pattern' => 'estore/artikel-detail-infos/<articleId:\d+>', 'route' => 'estore/default/article']
    ];
```

createUrlDepneding on Rules
---------------------------
```php
<?= \luya\helpers\Url::to('estore/default/article', ['articleId' => 123]); ?>
```

$useAppLayoutPath
-----------------

By default it will now try to serach the layout in: __APP__/views/__MODULE__/layouts/main.php. If you want to use a layout inside if your module, you have to set;
```php
public $useAppLayoutPath = false;
```

page context
------------

use $this->context->pageTitle

moduleLayout
------------

use 
```php
$this->renderLayout([

]]); 
```php

to render a fake like layout inside modules


EXAMPLE
=======

controllers/DefaultController.php
```php
<?php
namespace app\modules\estore\controllers;

use Yii;

class DefaultController extends \app\modules\estore\base\EstoreController
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
base/EstoreController.php
```php
<?php
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
```