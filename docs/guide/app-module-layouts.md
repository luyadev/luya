# Controller Layouts

When using the render method inside a controller, the layout file of your application will be wrapped around the render output. This is [Yii2 Layout](http://www.yiiframework.com/doc-2.0/guide-structure-views.html#layouts) function, but in some cases you want to additionaly render another layout inside the controller for all the actions, this is why we came up with `$this->renderLayout($viewFile)`, a method where the behavior is similar to the layout wrapping process of Yii.

RenderLayouts is also a very common used behavior in estores, assume you have a controller for the estore and methods which display different stages - a basket, confirmation page, etc. - so maybe you like to display the total basket account on each page, this would be a perfect case for using `renderLayout` instead of repeating html each time.

### Example

We keep going with the estore example, lets assume we have an estore controller with 2 actions.

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

Now render layout will lookup for a `layout.php` file inside your views folder where the other views (confirm and basket) are. The layout can also get the context informations from the controller. An example of what the layout file could look like:

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
