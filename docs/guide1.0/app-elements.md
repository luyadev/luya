# Html Element Component

The basic idea behind the *HTML Element Component* is based on a behavior known from *Angular Directives*. In a huge web project you have several html parts you may have to use an several locations but with different contents. Lets assume you have a Teaser-Box which contains a title and a picture, so the variables are the picture and the title, but the html base will be the same on all pages.

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

Where `button` is the name of the element closure defined in your elements.php file. In order to get and render an element in twig use the following function:

```
{{ element('button', 'https://luya.io', 'Go to website') }}
```

## Render view file


When you have a more complex html element, the possibility to concate the html parts seems to look a little ugly, for this reason you can also render a view file with the function `render()`. This mehtod will render a defined TWIG file which is located in *@app/views/elements/__NAME__.twig*.

```php
'myElementButton' => function($href, $name) {
    return $this->render('button', ['href' => $href, 'name' => $name ]);
}
```

The above example will render the file `button` with the paremeters `['href' => $href, 'name' => $name ]`. The twig file (*button*) must be stored in the folder `@app/views/elements` with the name `button.twig`. An example content of `@app/views/elements/button.twig` could look like this:

```
<a href="{{ href }}" class="btn btn-primary">{{ name }}</a>
```

### Rekursives Rendering

Sometimes you want to render another element component inside another template, you can use the above mentioned `element` twig function. Example recursiv rendering:

```
<div class="teaser-box">
    <h1>{{ title }}</h1>
    <p>{{ description }}</p>
    {{ element('button', buttonHref, buttonName) }}
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
            'class' => 'styleguide/Module',
            'password' => 'myguide',
        ]
    ]
]
```

When you have successfull configure the styleguide module you can access it trough the url:

(http://mywebsite.com/styleguide)[http://mywebsite.com/styleguide]