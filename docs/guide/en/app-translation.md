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
echo Yii::t('app', 'foo');
```

Variables in translations
--------------------------
if you have a parameter to use in the translation
```php
$paramValue = time();

echo Yii::t('app', 'foo-param', $paramValue);
```

the translation inside the messages array must look like:
```php
return [
	'foo-param' => 'Its now {0} in unix timestamp!'
];
```
see: [yii2 messages dok](https://github.com/yiisoft/yii2/blob/master/docs/guide/tutorial-i18n.md)