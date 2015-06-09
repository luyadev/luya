Create translations
====================
Createa a `message` folder in your application root folder. 

register the messages component in your config:
```php
'components' => [
    'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
            ],
        ],
    ]
]
```

folder strcuture:
```
messages
	de
		- app.php
	en
		- app.php
```

example content of `messages/de/app.php`
```
return [
    'foo' => 'Ich bin der Deutsche value für "Foo"',
];
```

use:
```php
$i18n = Yii::t('app', 'foo');
```