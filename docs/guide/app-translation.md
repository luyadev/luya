# Translation / Messages

This section explains how to use the [Yii Messaging system](http://www.yiiframework.com/doc-2.0/guide-tutorial-i18n.html#message-translation) inside a LUYA Project. This is a summary guide. To use the translation/messaging system in your controller or view files you have to configure the yii2 i18n component:

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

Now all the message with the prefix `app` will be loaded into the message component when the i18n component will be initialized. Now you have to define the files for the `app` prefix, which are located in your application (@app) folder `messages`. An example structure of the message folder could looke like this for the prefix app:

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

### Message Source Content

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

### Using translation in Twig

There is also a twig function which allows you to retrieve the content like in Yii:t:

```
t('app', 'title_top')
```

### Placeholders as Parameters

Sometimes you may want to add a placeholder you can fill up with specific content. You can use a key for the placholder or using the array keys:

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

While the second example needs a speicifc key `date` as parameter:

```php
echo Yii::t('app', 'tomorrow', ['date' => time()]);
```

#### Conditions with parameters

Sometimes you want to change the output inside the translation file based on input paremter values, lets assume the variables $slots has been assigend with the amount of left seats:

```
{slots, plural,=1{Only 1 place} =2{Only 2 places} other{Places}} available
```

Lets see what happens when the value of `$slots` is:

+ **1** = Only 1 place available
+ **2** = Only 2 places available
+ **3** = Places available
