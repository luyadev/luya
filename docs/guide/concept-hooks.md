# Hook

LUYA has a built in hooking mechanism which allows you to print code in various sections. The {{luya\Hook}} class is similar to [Yii events](http://www.yiiframework.com/doc-2.0/guide-concept-events.html).

Let´s assume we have a layout file with a section output which is used sometimes but could be blank as well:

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

## Hooks setup

Now a hooking listener is setup which is listening to the identifier `layoutFooter`. After setting up the hook listener, the {{luya\Hook}} can be filled with content from various files like blocks, controllers or widgets.

Let´s assume we have a controller with an action:

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

You can also provide an array instead of a callable function in order to have a more structured object oriented way:

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

If {{luya\Hook::on()}} is called multiple times in a request cycle the output will concated and sorted by execution time.

## Using array output

Sometimes it is more convenient to iterate elements instead of concant the output. This can be helpful e.g. if you are working with list outputs:

```php
Hook::on('fooBarArray', function($hook) {
    $hook[] = 'Hello';
    $hook[] = 'World';
});
Hook::on('fooBarArray', function($hook) {
    $hook[] = 'Hello';
    $hook[] = 'LUYA!';
});
```

As the {{luya\Hook::iterate()}} method can be called multiple times the hook iteration array contains now 4 elements which can be rendered as following:

```php
<ul>
    <?php foreach (Hook::iterate('fooBarArray') as $item): ?>
        <li>
            <?= $item; ?>
        </li>
    <?php endforeach; ?>
</ul>
```

The rendered output for the iteration example:

```html
<ul>
    <li>Hello</li>
    <li>World</li>
    <li>Hello</li>
    <li>LUYA!</li>
</ul>
```

It´s also possible to use associated arrays with keys:

```php
Hook::on('fooBarArrayLinks', function($hook) {
    $hook['https://luya.io'] = 'LUYA Website';
    $hook['https://github.com'] = 'GitHub';
});
```

> When using array keys multiple times the last executed item will override the former key.

```php
<ul>
    <?php foreach (Hook::iterate('fooBarArrayLinks') as $url => $name): ?>
        <li>
            <a href="<?= $url; ?>"><?= $name; ?></a>
        </li>
    <?php endforeach; ?>
</ul>
```

The rendered output for the iteration example:

```html
<ul>
    <li><a href="https://luya.io">LUYA Website<a/></li>
    <li><a href="https://github.com">GitHub</a></li>
</ul>
```
