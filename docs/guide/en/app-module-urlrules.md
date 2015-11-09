$urlRules
---------
Each Module can have its own url Rules. Even its not access by module context, example ulrRules

```php
    public $urlRules = [
        ['pattern' => 'estore/testof/<id:\d+>', 'route' => 'estore/default/debug'],
        ['pattern' => 'estore/xyz', 'route' => 'estore/default/debug'],
    ];
```

You can also have composition url rules which will also match against the ***$app::composition->getFull()*** url, like this:

```php

    public $urlRules = [
        ['pattern' => 'estore/warenkorb', 'route' => 'estore/default/basket', 'composition' => 
            [
                'en' => 'estore/the-basket',
                'de' => 'estore/der-warenkorb'
            ]
        ],
    ];
```

those rules above will also match against the en/de compsition full url if there is any.

***Important***

All the luya module urlRules does have to "prefix" theyr pattern with the current module name, otherwise the urlRouting would load the default module registered for this project. (like cms)


createUrlDepneding on Rules
---------------------------
```php
<?= \luya\helpers\Url::toManager('estore/default/article', ['articleId' => 123]); ?>
```
