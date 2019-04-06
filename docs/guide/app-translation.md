# Translation / Messages

This section explains as a summary how to use the [Yii Messaging system](http://www.yiiframework.com/doc-2.0/guide-tutorial-i18n.html#message-translation) inside a LUYA project.

## Application translation

To use the translation/messaging system in your controller or view files you have to configure the Yii i18n component:

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

Now all the message with the prefix `app` will be loaded into the message component when the i18n component will be initialized. Now you have to define the files for the `app` prefix, which are located in your application (@app) folder `messages`. An example structure of the message folder could look like this for the prefix app:

```
.
└── messages
    ├── de
    │   ├── app.php
    │   └── app-otherparts.php
    └── en
        ├── app.php
        └── app-otherparts.php
```

## Register module translations

In order to register a {{luya\base\Module}} translation call the {{luya\base\Module::onLoad()}} method, a reusable alias can be defined here too.

```php
class Module extends \luya\base\Module
{
    public static function onLoad()
    {
        self::registerTranslation('mymodule', static::staticBasePath() . '/messages', [
            'mymodule' => 'mymodule.php',
        ]);
    }

    public static function t($message, array $params = [])
    {
        return parent::baseT('mymodule', $message, $params);
    }
}
```

The above registered module translation messages can be retrieved as `Module::t('Key', 'Value')` assuming the messages are located in `messages/en/mymodule.php`.

In order to provide translations for the admin menu ({{luya\admin\base\Module::getMenu()}}) just use the registered key in a translation file, like: `->itemApi('menu_access_item_user', 'admin/user/index', 'person', 'api-admin-user')` where `menu_access_item_user` is the key registered in your message file.

> Keep in mind when using the admin module menu translations you should name them after your module, assuming `myadminmodule` is the module name then this name should be used to register your translations, otherwise menu translations wont work!

## Message source content

The message source file itself which contains the translations for the specific language is an array with a key where you can identifier the message and a value which is the content. Example content for `messages/de/app.php`:

```php
return [
    'title_top' => 'Hello everyone, i am title top!',
    'title_footer' => 'This is just a footer title.',
    'body' => 'The body welcomes you.',
];
```

In order to use the defined message you can run the `Yii:t` method like this:

```php
echo Yii::t('app', 'title_top');
```

This would return *Hello everyone, i am title top!*.

## Placeholders as parameters

Sometimes you may want to add a placeholder you can fill up with specific content. You can use a key for the placeholder or using the array keys:

```php
return [
    'today' => 'Today <b>{0}</b>.',
    'tomorrow' => 'Tomorrow is the <b>{date}</b>.',
];
```

The first example `today` could be used like this:

```php
echo Yii::t('app', 'today', time());
```

While the second example needs a specific key `date` as parameter:

```php
echo Yii::t('app', 'tomorrow', ['date' => time()]);
```

## Conditions with parameters

Sometimes you want to change the output inside the translation file based on input parameter values, lets assume the variables $slots has been assigned with the amount of left seats:

```php
return [
    "placesAvailable" => "{slots, plural,=1{Only 1 place} =2{Only 2 places} other{Places}} available"
]
```

Lets see what happens when the value of `Yii::t("app", "placesAvailable", ["slots" => $slots])` is set:

+ if `$slots` =  1 : Only 1 place available
+ if `$slots` =  2 : Only 2 places available
+ if `$slots` =  3 : Places available
