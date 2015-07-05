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
Each Module can have its own url Rules. Even its not access by module context, example ulrRules

```php
    public $urlRules = [
        ['pattern' => 'estore/testof/<id:\d+>', 'route' => 'estore/default/debug'],
        ['pattern' => 'estore/xyz', 'route' => 'estore/default/debug'],
    ];
```

You can also have composition url rules which will also match against the ***$app::composition->getFull()*** url, like this:

```php

    public $urlRules = [
        ['pattern' => 'estore/warenkorb', 'route' => 'estore/default/basket', 'composition' => 
            [
                'en' => 'estore/the-basket',
                'de' => 'estore/der-warenkorb'
            ]
        ],
    ];
```

those rules above will also match against the en/de compsition full url if there is any.

***Important***

All the luya module urlRules does have to "prefix" theyr pattern with the current module name, otherwise the urlRouting would load the default module registered for this project. (like cms)

Module Context
-------------------
If a module is invoke by another module the context variable contains the name of the module which has invoke the active module. For example if the cms loades other modules, the loaded module can access the 
parent module with $this->context;

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