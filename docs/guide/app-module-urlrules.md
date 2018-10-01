# Module URL rules

When dealing with modules, several actions and pages you may would like to use nice readable urls instead of the default routing behavior. To do so, you can configure each module with url rules corresponding to a route.

## Configure rules

To configure a new rule you have to open the module file (`Module.php`) of the {{luya\base\Module}} where you want to add new url rules. Now you can add rules to the `$urlRules` property, which is an array where you have to add a new item. Each item must contain a route and a pattern.

```php
<?php
namespace app\modules\team;

class Module extends \luya\base\Module
{
    public $urlRules = [
        ['pattern' => 'my-basket', 'route' => 'estore/basket/index']
    ];
}
```

The url rule explained in details:

|Variable     |Description
|-------------|------------
|pattern      |The newly defined name for the rule which is what the end-users see.
|route        |To internal route used to determine the new location, based on the yii2 routing concept `module/controller/action`.

You can also use parameters in url rules:

```php
['pattern' => 'article-detail/<id:\d+>', 'route' => 'estore/article/index'],
```

Visit the [Yii Documentation](http://www.yiiframework.com/doc-2.0/guide-runtime-routing.html#parameterizing-routes) for more details about parameters.

> If you are using the module in a CMS context your patterns must be prefix with the module name like `team/my-basket`, otherwise the CMS can not auto replace the new pattern with the CMS context information.

Below, a helping list of regex expressions you may use to generate your variables inside the urls:

|Regex      |Description        |Example
|---        |---                |---
|`\d`       |Matches any digit/numbers|`<id:\d+>`
|`\w`       |Any word character (letter, number, underscore)|`<hash:\w+>`
|`[abc]`    |Only the letters a, b or c|`<string:[abc]+>`
|`[a-z0-9]` |All letter chars a-z (only lowercase) and numbers from 0 to 9|`<alias:[a-z0-9]+>`
|`[a-z0-9\-]`|Slugable url rules known as aliases|`<alias:[a-z0-9\-]+>`

## Using the rule to make a link

When you have defined url rules for your module you may want to use them in your view and/or controller files to generate the links that the user can click on it. To make links we use the {{luya\helpers\Url}} class.
Lets assume we create links for the above created rule patterns:

```php
\luya\helpers\Url::toRoute(['/estore/basket/index']);
```

And a the parameterized route:

```php
\luya\helpers\Url::toRoute(['/estore/article/index', 'id' => 123]);
```

## Multilingual language patterns

If you have multi lingual pages you need patterns for different languages which can be defined in your `$urlRules` configuration too. This will only work when defining the rules inside a module.

```php
public $urlRules = [
    ['pattern' => 'estore/basket', 'route' => 'estore/basket/default', 'composition' => 
        [
            'fr' => 'estore/panier',
            'de' => 'estore/warenkorb'
        ]
    ],
];
```

In order to define the url rules from the urlManager config scope, you can just prefix the route with the given composition pattern. So the same example from above inside the config would look like this:

```php
'urlManager' => [
    'rules' => [
        'basket' => 'en/estore/basket/default',
        'warenkorb' => 'de/estore/basket/default',
        'panier' => 'fr/estore/basek/default',
    ],
],
```

To verify which composition language is used you can dump `Yii::$app->composition->language`. The {{luya\web\Composition}} component is taking care of LUYA multi language websites and is registered by default for all LUYA projects.
