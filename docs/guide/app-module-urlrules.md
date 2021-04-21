# Module URL rules

When dealing with modules, several actions and pages you may would like to use nice readable urls instead of the default routing behavior. To do so, you can configure each module with url rules corresponding to a route.

## Configure rules

To configure a new rule you have to open the module file (`Module.php`) of the {{luya\base\Module}} where you want to add new url rules. Now you can add rules to the `$urlRules` property, which is an array where you have to add a new item. Each item must contain a route and a pattern.

```php
<?php
namespace app\modules\estore;

class Module extends \luya\base\Module
{
    public $urlRules = [
        [
            'pattern' => 'my-basket',
            'route' => 'estore/basket/index',
        ],
        'my-basket' => 'estore/basket/index', // which is equals to the above
    ];
}
```

The possible url rule keys if not the short form is used.

|Key     |Description
|-------------|------------
|`pattern`      |The newly defined name for the rule which is what the end-users see.
|`route`        |To internal route used to determine the new location, based on the yii2 routing concept `module/controller/action`.
|`defaults`     |Provide default values for a given pattern param `'defaults' => ['date' => 0]`
|`composition`  |Provides the option to defined multi lingual patterns for a given language `'composition' => ['fr' => 'estore/panier', 'de' => 'estore/warenkorb']`

You can also use parameters in url rules:

```php
'article-detail/<id:\d+>' => 'estore/article/index',
```

Visit the [Yii Documentation](http://www.yiiframework.com/doc-2.0/guide-runtime-routing.html#parameterizing-routes) for more details about parameters.

> **CMS Context:** If you are using the module in a CMS context your patterns must be prefix with the module name, otherwise the CMS can not auto replace the new pattern with the CMS context information. For example redirecting from controller foo action index to controller bar action index inside a module both url rules must be prefix. For foo `['MODULE/name-for-foo-index' => 'MODULE/foo/index']` for bar `['MODULE/name-for-bar-index' => 'MODULE/bar/index']` so they must have the full qualified route with the name of the module used in the config to register the module. Also the patterns **must** prefix the module name.

> **CMS Page Context:** When you place a **module block** in order to render a module controller and the rendered content produces links (for example a user login, and there is a link to another action where user can reset its password) its important to **disable strict render in cms settings**! Edit Pen -> Expert -> Strict URL Parsing -> Disable

Below, a short list of regex expressions you may use to parameterize the URLs:

|Regex      |Description        |Example
|---        |---                |---
|`\d`       |Matches any digit/numbers|`<id:\d+>`
|`\w`       |Any word character (letter, number, underscore)|`<hash:\w+>`
|`[abc]`    |Only the letters a, b or c|`<string:[abc]+>`
|`[a-z0-9]` |All letter chars a-z (only lowercase) and numbers from 0 to 9|`<alias:[a-z0-9]+>`
|`[a-z0-9\-]`|Slugable url rules known as aliases|`<alias:[a-z0-9\-]+>`

## Using the rule to make a link

When you have defined url rules for your module you may want to use them in your view and/or controller files to generate the links that the user can click on it. To make links we use the {{luya\helpers\Url}} class. Lets assume we create links for the above created rule patterns:

```php
\luya\helpers\Url::toRoute(['/estore/basket/index']);
```

And a the parameterized route:

```php
\luya\helpers\Url::toRoute(['/estore/article/index', 'id' => 123]);
```

> Its also possible to make links for given Page IDs or Module Names inside the CMS therefore take a look at CMS {{luya\cms\helpers\Url}} which inherits from {{luya\helpers\Url}}

## Multilingual language patterns

If you have multi lingual pages you need patterns for different languages which can be defined in your `$urlRules` configuration too. This will only work when defining the rules inside a module.

```php
public $urlRules = [
    [
        'pattern' => 'estore/basket',
        'route' => 'estore/basket/default',
        'composition' => [
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

> When composition is enabled, it will take the correct route for the current language and prefix the pattern if enable in composition config.

To verify which composition language is used you can dump `Yii::$app->composition->langShortCode`. The {{luya\web\Composition}} component is taking care of LUYA multi language websites and is registered by default for all LUYA projects.

## Application Controller Routes

When the CMS module is enabled it will take over all URLs who are not covered by URL rules in the URL manager, otherwise the CMS won't have the ability to generate pages with slugs and nested subpages. When working with "default" Yii Framework controllers an URL rule is required to get accessable web URL. Let's assume we have a controller which returns data for an async request, we would like to access the url in order to make an ajax call somewhere in the layout.

Create the controller, change response format to json and return an array:

```php
<?php

namespace app\controllers;

class AjaxController extends \luya\web\Controller
{
    public function actionData()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['foo' => 'bar'];
    }
}
```

In order to get an URL which is accessable, we need to set an URL rule in the config of the components section:

```php
// ... 
'urlManager' => [
    'rules' => [
        'ajax-data' => 'ajax/data',
    ]
]
```

Now the url creation can be done with the {{luya\helpers\Url}} helper, as the rule will take precedence over the CMS {{luya\cms\frontend\components\CatchAllUrlRule}}:

```php
$url = \luya\helpers\Url::toRoute(['/ajax/data']);
```
