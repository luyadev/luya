# Hook

LUYA has a built in Hooking mechanism, which allows you to print code in various sections. The {{luya\Hook}} class is similar to Yii Events.

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

When {{luya\Hook::on}} is called multiple times in a request cycle, the output will concated and is sorted by execution time.

## Array output

Sometimes its more convenient to iterate elements instead of concant the output. This can be helpfull when working with list output:

```php
Hook::on('fooBarArray', function($hook) {
    $hook[] = 'Hello';
    $hook[] = 'World';
});
Hook::on('fooBarArray', function($hook) {
    $hook[] = 'Its';
    $hook[] = 'LUYA!';
});
```

As the {{luya\Hook::on}} method can be called multiple times the hook iteration array contains now 4 elements which can be rendered as following:

```php
<ul>
<?php foreach (Hook::iterate('fooBarArray') as $item): ?>
    <li><?= $item; ?></li>
<?php endforeach; ?>
</ul>
```

The rendered output for the iteration example:

```html
<ul>
    <li>Hello</li>
    <li>World</li>
    <li>Its</li>
    <li>LUYA!</li>
</ul>
```

Its possible to use assoc arrays with keys.

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
    <li><a href="<?= $url; ?>"><?= $name; ?></a></li>
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
