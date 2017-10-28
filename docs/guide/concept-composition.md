# Composition Concept

When dealing with multiple language websites the {{\luya\web\Composition}} component is a powerfull tool to help building **multi lingual url rules**, generate websites with **localisation prefixes** (like www.example.com/de/ch) or define domains which should automatic trigger a website language trough **host info mapping**.

To configure and setup the composition component you have to open the application configuration file and update the composition component in the components section. The below examples shows a very advanced use of the composition in order to show all possibilities.

```php
return [
    'components' => [
        // ...
        'composition' => [
            'hidden' => false,
            'pattern' => '<langShortCode:[a-z]{2}>-<countryShortCode:[a-z]{2}>',
            'default' => [
                'countryShortCode' => 'us',
                'langShortCode' => 'en',
            ],
            'hostInfoMapping' => [
                'http://example.us' => ['langShortCode' => 'en', 'countryShortCode' => 'us'],
                'http://example.co.uk' => ['langShortCode' => 'en', 'countryShortCode' => 'uk'],
                'http://example.de' => ['langShortCode' => 'de', 'countryShortCode' => 'de'],
            ],
        ],
        // ...
    ],
];
```

The above example will generate a language and country specific prefix urls for example `http://example.com/en-us/` and the `hostInfoMapping` domains who points to this website would have the predefined settings defined in the array.

In order to access data from the composition component you can access the composition component by its keys:

```php
$langShortCode = Yii::$app->composition['langShortCode'];
$countryShortCode = Yii::$app->composition['countryShortCode'];
```

> Note: In the CMS context, the **langShortCode** is **required** by default. Other patterns can be added, but the langShortCode is bound to the CMS language table from the database. When creating a LUYA website without the CMS module you can complet change those patterns.

## Disable the Component

When your website is not running in an multi lingual context and/or you do not want to make use of the composition component you can turn it off by setting {{luya\web\Composition::hidden}} to true. As the composition will be loaded always, you can only tell the component to **not** prefix your urls with the composition patterns.

```php
return [
    'components' => [
        // ...
        'composition' => [
            'hidden' => true,
            'default' => ['langShortCode' => 'en'],
        ]
    ]
];
```
