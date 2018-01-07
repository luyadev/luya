# Html Element Component

The basic idea behind the {{\luya\web\Element}} component is based on a behavior known from **AngularJS Directives**. In a huge web project you have several HTML parts you may have to use in several locations but with different contents. 
Lets assume you have a teaser box which contains a title and a picture. So variables are the picture and the title, but the HTML base will be the same on all pages.

Basic example of a HTML partial wich will be reused in different pages with different contents:

```html
<div class="teaser-box">
    <h1>Title</h1>
    <p>Description</p>
    <a class="btn btn-primary" href="https://luya.io">Read more</a>
</div>
```

Now you can create a HTML element component for this.


## Create HTML element component and use it

To add a new HTML element component, change into your project root folder (@app) and create a PHP file with the name `elements.php`. This file will contain all the element partials for this project. An element is defined by a *name* and a corresponding *closure*. Below, an example setup for the `elements.php` file:

```php
<?php
return [
    'button' => function($href, $name) {
        return '<a class="btn btn-primary" href="'.$href.'">'.$name.'</a>';
    },
    'teaserbox' => function($title, $description, $buttonHref, $buttonName) {
        return '<div class="teaser-box"><h1>'.$title.'</h1><p>'.$description.'</p>'.$this->button($buttonHref, $buttonName).'</div>';
    },
];
```

> Elements can also be added in a more dynamic way, e.g. by accessing the *element* component in your controller: 
`Yii::$app->element->addElement('elementName', function() { });`

To use a defined element you can access the `element` component which is registered to any LUYA project by default, `Yii::$app->element`.

You can directly call the name of your element:

```php
echo Yii::$app->element->button('https://luya.io', 'Go to website');
```

Where `button` is the name of the element closure defined in your elements.php file.

## Render a view file

When you have a more complex HTML element, the possibility to concate all the HTML parts looks a bit ugly, therefore you can also render a view file with the function `render()`. This method will render a defined PHP template which is located in *@app/views/elements/__NAME__.php*.

```php
'myElementButton' => function($href, $name) {
    return $this->render('button', ['href' => $href, 'name' => $name ]);
}
```

The above example will render the element file, e.g. `button.php` with the parameters `['href' => $href, 'name' => $name ]`. 
The view file for the button must be stored in the folder `@app/views/elements` with the name `button.php`. An example content of `@app/views/elements/button.php` could look like this:

```php
<a href="<?= $href; ?>" class="btn btn-primary"><?= $name; ?></a>
```

### Recursive rendering

Perhaps you need to render another element component inside another template, therefore just use the global element component  (`Yii::$app->element`) for recursive rendering, e.g.:

```php
<div class="teaser-box">
    <h1><?= $title; ?></h1>
    <p><?= $description; ?></p>
    <?= Yii::$app->element->button($buttonHref, $buttonName); ?>
</div>
```

Of course the above example requires as well that the variables `title`, `description`, `buttonHref` and `buttonName` have been passed to the recursiv element rendering of the button.

# Automatic styleguide from elements 

LUYA provides a styleguide module which renders all the available elements with example content, so you can share all the elements with other designer to discuss and test changes based on elements instead on a finished web page. 
This gives you the ability to make more specific changes and test them properly before the final implementation.

First adding the LUYA styleguide module to your Composer json:

```sh
composer require luyadev/luya-module-styleguide
```

Then configure the module in your project config file, the password is protecting the styleguide page by default:

```php
return [
    // ...
    'modules' => [
        // ...
        'styleguide' => [
            'class' => 'luya\styleguide\Module',
            'password' => 'myguide',
            'assetFiles' => [
                'app\assets\ResourcesAsset',
            ],
        ]
    ]
]
```

If the styleguide module is successfully configured it is accesible it trough the url: `yourwebsite.com/styleguide`

## Mocking arguments

The styleguide will automatically use default values for each element. Assuming you have an element argument `$foo` this argument will recieve the value `$foo` inside the styleguide.

```php
'test' => function($foo) {
    return '<p>'.$foo.'</p>';
}
```

The styleguide would print the element as:

```php
<p>$foo</p>
```

In order to mock the arguments with more meaning full values you can pass them when creating the element inside the `elements.php` file:

```php
<?php
return [
    'test' => [function($foo) {
        return '<p>'.$foo.'</p>';
    }, [
        'foo' => 'Mocking value for $foo',
    ]],
];
```

As now the element `test` has a mocked $foo paremter and will return the following rendered content in the styleguide:

```php
<p>Mocking value for $foo</p>
```

> The mocking element options will not affect your elements in any way when using them in your application and is only used in the styleguide
