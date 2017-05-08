# Html Element Component

The basic idea behind the {{\luya\web\Element}} component is based on a behavior known from *Angular Directives*. In a huge web project you have several html parts you may have to use an several locations but with different contents. Lets assume you have a Teaser-Box which contains a title and a picture, so the variables are the picture and the title, but the html base will be the same on all pages.

Casual Example of an html partial you may reuse in different pages with different content.

```html
<div class="teaser-box">
    <h1>Title</h1>
    <p>Description</p>
    <a class="btn btn-primary" href="https://luya.io">Mehr erfahren</a>
</div>
```

Now you can create an html element component for this.


## Create Element and Use

To add a new html element component, go into your Application Folder (@app) and create a php file with the name `elements.php`. This file will contain all the element partials for this Project. An element is defined by a *name* and a corresponding *closure*. Below en example setup for `elements.php` file:

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

> Elements can also be added in a more dynamic way, by accessing the *element* component in your controller:  `Yii::$app->element->addElement('elementName', function() { });`.

To use a defined element you can access the `element` Component which is registered to any LUYA project by default, `Yii::$app->element`.

You can directly call the name of your element:

```php
echo Yii::$app->element->button('https://luya.io', 'Go to website');
```

Where `button` is the name of the element closure defined in your elements.php file.

## Render view file


When you have a more complex html element, the possibility to concate the html parts seems to look a little ugly, for this reason you can also render a view file with the function `render()`. This method will render a defined php template which is located in *@app/views/elements/__NAME__.php*.

```php
'myElementButton' => function($href, $name) {
    return $this->render('button', ['href' => $href, 'name' => $name ]);
}
```

The above example will render the file `button` with the paremeters `['href' => $href, 'name' => $name ]`. The view file (*button*) must be stored in the folder `@app/views/elements` with the name `button.php`. An example content of `@app/views/elements/button.php` could look like this:

```php
<a href="<?= $href; ?>" class="btn btn-primary"><?= $name; ?></a>
```

### Recursive Rendering

Sometimes you want to render another element component inside another template, therefore just use the element component from the global Yii::$app scope. Example recursiv rendering:

```php
<div class="teaser-box">
    <h1><?= $title; ?></h1>
    <p><?= $description; ?></p>
    <?= Yii::$app->element->button($buttonHref, $buttonName); ?>
</div>
```

Of course the above example requires also that you have assigned the variables `title`, `description`, `buttonHref` und `buttonName` passed to the recursiv element rendering of button.

# Automatic Styleguide from Elements 

We have build a styleguide modules which renders all the available elements with example content, so you can share all the elements with other designer and make and discuss changes based on elements on not just on a finished web page, this gives you the ability to make more specific changes.

Add the luya style guide module to your composer json

```sh
require luyadev/luya-module-styleguide
```

Configure the Module in your project config, the password is protected this page by default.

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

When you have successfull configured the styleguide module you can access it trough the url: `mywebsite.com/styleguide`

## Mocking Arguments

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

> The mocking element options will not affect your elements in any way when using them in your application and is only used in the Styleguide