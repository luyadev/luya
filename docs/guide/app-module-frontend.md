# Frontend module

If specific logic have to be applied to your website, e. g. a form where user can input data or you may load data from a database and render a custom view then you can create a frontend module. The module can be integrated into your CMS or called directly via the module url.

Frontend modules are also a very common way to redistributed logic of a controller but still let the user implement the view files to fit their look.

### View rendering options

As already mentioned, frontend modules commonly contain controller logic but may use the view files from the project where the module in integrated. Therefore a possibility is provided which let you regulate where the view files of a module should be rendered.

```php
<?php
namespace app\modules\team;

class Module extends \luya\base\Module
{
    public $useAppViewPath = true; // views will be looked up in the @app/views folder.
}
```

You can enable this option for all modules by changing the default value inside your module class or you can even configure the views location inside your configuration afterwards.

- `$useAppViewPath = true` = The view path of the module will be: *@app/views*
- `$useAppViewPath = false` = The view path of the module will be: *@modulename/views*

#### CMS context

When including a module into the CMS, the rendering of your module view file will automatically ignore the layout, otherwise you would have a mess with HTML as the CMS already wraps its CMS layout and afterwards also wraps the layout. But you may use the [frontend layouts](app-module-layouts.md) which allows you to use a sub layout for all the module controller views.

## Title and meta information

LUYA uses the default implementation of the title variable inside the [Yii Titel-Tag](http://www.yiiframework.com/doc-2.0/guide-structure-views.html#setting-page-titles) view object, you can override the title inside an action:

```php
public function actionIndex()
{
    // change the title of the page
    $this->view->title = 'Hello World title';
    
    // render your file
    return $this->render('index');
}
```

But you can also directly set the title inside your view file:

```php
<?php $this->title = 'Hello World title'; ?>
<p>...</p>
```

This is equal for meta tags or descriptions:

```php
public function actionIndex()
{
    // register meta tag
    $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'LUYA, Yii, PHP']);
    $this->view->registerMetaTag(['name' => 'description', 'content' => 'Description of this page.'], 'metaDescription');
    
    return $this->render('index');
}
```

Or in the view file:

```php
$this->registerMetaTag(['name' => 'keywords', 'content' => 'LUYA, Yii, PHP']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Description of this page.'], 'metaDescription');
```

## Additional notes

### Forms

As the csrf validation is enabled by default, you have to integrate them into your forms (if you are not using the ActiveForm Widget). You will find all information here: [Guide to include CSRF Token forms](http://zero-exception.blogspot.ch/2015/01/yii2-using-csrf-token.html). LUYA will auto insert the csrf meta tag to your head section if you are using the CMS Module.

Quick fix without disabling csrf validation and not using the ActiveForm Widget: 

```php
<form action='#' method='POST'>
   <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken; ?>" />
   ....
</form>
```

In order to disable the csrf validation set `$enableCsrfValidation` to `false` inside your Controller.

```php
class MyController extends \luya\web\Controller
{
    public $enableCsrfValidation = false;
    
    // action content ...
}
```

### Controller actions

Controller provides a very flexible way to implement logic into your module following the methodology from [Yii controller structure](http://www.yiiframework.com/doc-2.0/guide-structure-controllers.html).

Controller actions are pretty powerful functions to enrich your application, basically `module/controller/actions` is the concept in short, therefore some basic examples of use cases are explained below.

Let´s assume we have this default controller with following actions:

```php
namespace app\modules\frontendmodule\controllers;

use Yii;
use luya\web\Controller;

class DefaultController extends Controller
{
    
    public function actionHello() 
    {
        return 'I am the hello action';
    }
    
    public function actionBye() 
    {
        return 'I am the bye action';
    }
    
    public function actionWhoAmI()
    {
        $id = $this->id;  // returns the controller id
        return $id;
    }
}
```

Those actions are already accessible by an exact url, because we have a `DefaultController` in our `frontendmodule` most likely the URL for the `actionHello()` is:

`your-public-project-domain/frontendmodule/default/hello`

Please keep in mind that those actions are case sensitive, which means `actionWhoAmI` it is accessible via the url:

`your-public-project-domain/frontendmodule/default/who-am-i`

Of course the URL rules in the `Module.php` can be used for pointing to controllers and views.
