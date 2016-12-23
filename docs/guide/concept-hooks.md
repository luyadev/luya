# Hook

LUYA has a built in Hooking mechanism, which allows you to print code in various sections.

Assuming to have a Layout file which has section output which can be used sometimes, but could also be blank.

```php
<html>
<head>
    <title>Page</title>
</head>
<body>
    <nav>
    ...
    </nav>
    
    <?= $content; ?>
    
    <footer>
        <?= Hook::string('layoutFooter'); ?>
    </footer>
</body>
</html>
```

Now a hooking listener is setup which listens to the identifier `layoutFooter`. After setting up the hook listener, the Hook can be filled with content from various files like Blocks, Controllers or Widgets.

Assuming to have a Controller with an action.

```php
class DefaultController extends \luya\web\Controller
{
    public function actionIndex()
    {
        Hook::on('layoutFooter', function($hook) {
            return 'Output from the Hook.';
        });
    
        return $this->render('index');
    } 
}
```

You can also provide an array instead of callable function in order to have a more structured object oriented way.

```php
class DefaultController extends \luya\web\Controller
{
    public function actionIndex()
    {
        Hook::on('layoutFooter', [$this, 'footerHook']);
    
        return $this->render('index');
    } 
    
    public function footerHook($hook)
    {
        // do something
        return $this->renderPartial('_footerHook', []);
    }
}
```
