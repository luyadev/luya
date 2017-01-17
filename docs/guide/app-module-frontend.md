# Frontend Modul

When you have specific logic you want to apply to your website, this can be a form where user can input data, or you may load data from a database and render a custom view then you can create a frontend module. You can then integrate the module into your cms or open the url of the module directly, depends on what you wish to do.

Frontend module are also a very common way to redistributed logic of a controller, but let the user implement the view files to fit their look.

### View rendering options

As already mentioned, frontend modules commonly contain controller logic, but my use the view files from the project you integrate the module, therefore we have created an possibility you can regulate where the view files of a module should be rendered.

```php
<?php
namespace app\modules\team;

class Module extends \luya\base\Module
{
    public $useAppViewPath = true; // views will be looked up in the @app/views folder.
}
```

You can enable this option for all modules by chaning the default value inside your module class or you can even configure the views location inside your configuration afterwards.

- `$useAppViewPath = true` = The view path of the module will be: *@app/views*
- `$useAppViewPath = false` = The view path of the module will be: *@modulename/views*

#### CMS-Context

When including a module in the cms, the rendering of your modules view file will automaticcaly ignore the layout, oterhiwse you would have a mess with html as the cms already wraps its cmslayout and afterwards also wraps the layout. But you may use the [Frontend Layouts](app-module-layouts.md) which allows you to use a sub layout for all the module controller views.

## Title and Meta-Informations

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

But you can also directly set the title inside your view file

```php
<? $this->title = 'Hello World title'; ?>
<p>...</p>
```

This is equals for meta tags or descriptions:

```php
public function actionIndex()
{
	// register meta tag
    $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Luya, Yii, PHP']);
    $this->view->registerMetaTag(['name' => 'description', 'content' => 'Description of this Page.'], 'metaDescription');
    
    return $this->render('index');
}
```

or in the view file:

```php
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Luya, Yii, PHP']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Description of this Page.'], 'metaDescription');
```

## Additional notes

### Forms

As the csrf validation is enabled by default, you've to integrate them into your forms (if you're not using the ActiveForm Widget). You'll find all information here: [Guide to include CSRF Token forms](http://zero-exception.blogspot.ch/2015/01/yii2-using-csrf-token.html). Luya will auto insert the csrf meta tag to your head section if you are using the CMS Modul.

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
