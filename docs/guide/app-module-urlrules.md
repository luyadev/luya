# Module URL Rules

When dealing with modules with several actions and pages you may use nice readable urls instead of the default routing behavior. To do so, you can configure each module with url rules corresponding to a route.

## Configure Rules

To configure a new rule you have to open the Module file (`Module.php`) of the {{luya\base\Module}} you want to add new url rules. Now you can add rules to the `$urlRules` propertie, which is an array where you have to add a new item each item must contain a route and a pattern.

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
|pattern      |The newly defined name for the rule, which is what the end-users can see.
|route        |To internal route used to determine the new location, based on the yii2 routing concept `module/controller/action`.

You can also use parameters in url rules:

```php
['pattern' => 'article-detail/<id:\d+>', 'route' => 'estore/article/index'],
```

Visit the [Yii Documentation](http://www.yiiframework.com/doc-2.0/guide-runtime-routing.html#parameterizing-routes) for more details about parameters.

> When you using the module in a cms context, your patterns must be prefix with the module name like `team/my-basket`, otherwise the cms can not auto replace the new pattern with the cms context informations.

Here also a helping list of regex expressions you may use to generate your variables inside the urls:

|Regex      |Description        |Example
|---        |---                |---
|`\d`       |Matches any digit/numbers|`<id:\d+>`
|`\w`       |Any word character (letter, number, underscore)|`<hash:\w+>`
|`[abc]`    |Only the letters a, b or c|`<string:[abc]+>`
|`[a-z0-9]` |All letter chars a-z (only lowercase) and numbers from 0 to 9|`<alias:[a-z0-9]+>`
|`[a-z0-9\-]`|Slugable url rules known as aliases|`<alias:[a-z0-9\-]+>`

## Using the Rule to make a Link

When you have defined url rules for your module, you may want to use them in your view/controller files to generate the links where the user can click on it. To make links we use the {{luya\helpers\Url}} class. Lets assume we create links for the above created rule patterns.

```php
\luya\helpers\Url::toRoute(['/estore/basket/index']);
```

and the parameterized route

```php
\luya\helpers\Url::toRoute(['/estore/article/index', 'id' => 123]);
```

## Multilingual language patterns

When you have multi lingual pages, you need patterns for different languages, you can define them in your `$urlRules` configuration.

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

To verify what composition language is used you can dump `Yii::$app->composition->language`, the {{luya\web\Composition}} component is taking care of LUYA multi language websites and is registered by default for all LUYA projects.
