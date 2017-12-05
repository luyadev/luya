# Controller layouts

When using the render method inside a controller, the layout file of your application will be wrapped around the render output. This is the [Yii2 Layout](http://www.yiiframework.com/doc-2.0/guide-structure-views.html#layouts) function but in some cases you may would like to render another layout additionally inside the controller for all the actions. This is why we came up with `$this->renderLayout($viewFile)` which is a method where the behavior is similar to the layout wrapping process of Yii.

RenderLayouts is also a very common used behavior in e-stores, e. g. assume you have a controller for the e-store and methods which display different stages - a basket, confirmation page, etc. - so maybe you would like to display the total basket account on each page. This would be a perfect case for using `renderLayout` instead of repeating html each time.

### Example

Let´s keep going through the e-store example and assume we have an e-store controller with two actions.

```php
<?php
namespace app\modules\estore\controllers;

class DefaultController extends \luya\web\Controller
{
    /**
     * @return int Calculate the number of basket items
     */
    public function getBasketCount()
    {
        return 10;
    }

    /**
     * Returns all basket items for this user.
     */
    public function actionBasket()
    {   
        // add your basket action logic
        return $this->renderLayout('basket');
    }
    
    /**
     * Display confirmation page.
     */
    public function actionConfirm()
    {
        // add your confirmation action logic
        return $this->renderLayout('confirm');
    }
}
```

Now render layout will lookup for a `layout.php` file inside your views folder where the other views (confirm and basket) are placed. The layout can also get the context information from the controller. Below, an example how the layout file could look like:

```php
<div class="row">
    <div class="col-md-10">
        <!-- where the content of the basket and confirm layout will be returned -->
        <?= $content; ?>
    </div>
    
    <div class="col-md-2">
        <h1>Basket</h1>
        <p><?= $this->context->getBasketCount(); ?> item(s)</p>
    </div>
</div>
```
