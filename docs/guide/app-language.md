# Languages

LUYA provides a powerful multi language support as we have focused on multi lingual website very strong during the concept and development phase. In order to understand how to configure your site to fit your needs read the section below.

Keep in mind that the `language` property of your application is the main setting for the Yii translation system.

## How to configure

As LUYA is developed as a modular system the languages must be configured in several parts of the system. The multi lingual support works with or without cms.

There is a component known as [composition component](concept-composition.md) which is dealing with the language settings. The component is invoked by the application boot process and changes the base url inside the urlManager based on your configuration. If the composition is actived and not hidden it will manipulate the {{yii\base\Application::$language}}. So it can override your language from the configuration.

You always have to define the default language of your application configs:

```php
'composition' => [
    'hidden' => false, // if it is a single language page probably you do not want to add the language prefix `en/my-test`, it would be `my-test` only.
    'default' => ['langShortCode' => 'en'], // the default language for the composition should match your default language shortCode in the langauge table.
],
```

Now you have set the default language of the application to **en** and the language prefix is available and will be appended to all urls. If hidden is enabled, it would still set the language, but would not prepend the string ot every url.

When using the CMS Module the configuration must match your configuration of the system languages (which is stored in the database) below a screen shot where the language short code *en* is set as *default language*:

![set-default-language](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/set-default-language.jpg "Set CMS default language")

## Localisation with locales

As the composition component can override the {{yii\base\Application::$language}} which is the base property for all translations within a Yii system you can define localisations for each language. Localisation are usually set trough setlocale() this is what LUYA does in the {{luya\traits\ApplicationTrait}}. You can define a localisation file for each language with the {{luya\traits\ApplicationTrait::$locales}} property, for example when language `de` is given it should take the `de_CH.utf8` locale file:

```php
'locales' => [
    'de' => 'de_CH.utf8',
    'en' => 'en_GB.utf8',
],
```

This is configured in the root level of your application config.

## Other language related topics

+ Language switcher
+ Multi language url rules
+ Crud i18n
+ Domain matching language
+ Composition add another pattern
+ Get current application language within controllers
