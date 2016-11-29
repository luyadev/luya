# Composition Concept

When deailing with multiple languages the {{\luya\web\Composition}} component is a powerfull tool to help building **multi lingual url rules**, generate websites with **locatisation prefixes** (like example.com/de/ch), define domains which should automatic trigger a website language with **host info mapping**.

To configure and setup the composition component you always have to open your application configuration file and update the composition in the components section. The below examples shows a very advanced use of the compoisition in order to show all possibilities.

```php
return [
    'components' => [
        // ...
        'composition' => [
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

The above example will generate language and country specific prefix urls for example `http://example.com/en-us/` and the `hostInfoMapping` domains who points to this website would have the predefined settings defined in the array.

In order to access data from the composition component you can access the above configure patterns as followed:

```php
$langShortCode = Yii::$app->composition['langShortCode'];
$countryShortCode = Yii::$app->composition['countryShortCode'];
```

> Note: In the CMS context, the `langShortCode` is required by default and other patterns can be added if you like, but the langShortCode is bound to the CMS language tables from the database. When creating a luya website without CMS/ADMIN modules you can complet change those pattersn.