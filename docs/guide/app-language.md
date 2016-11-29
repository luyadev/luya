# Languages

LUYA has a strong multi language support as we have focused on multi lingual website very strong during the concept and development phase. In order to understand how to configure your site to fit your needs read the section below. Some parts of the language behavior are also importent in different areas, like multi lingual url rules.

## How to configure

As LUYA is developed as a modular system the languages must be configured in several parts of the system. The multi lingual support works with or without cms but when using the cms (which is mostly the case).

There is component known as [composition component](concept-composition.md) which is dealing with the language settings. The component is invoken by the application boot process and changes the base url for the urlManager based on your configuration.

You always have to define the default language of your application:

```php
'composition' => [
    'hidden' => false, // if its a single language page, you dont want to add the language prefix `en/my-test` would be `my-test` only.
    'default' => ['langShortCode' => 'en'], // the default language for the composition should match your default language shortCode in the langauge table.
],
```

Now you have set the default language of the application to **en** and the language prefix is available and will be appended to all urls (hidden = false).

When using the CMS Module the configuration must match your configuration of the system languages (which is stored in the database) below a screenshot where the language short code *en* is set as *default language*:

![set-default-language](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/set-default-language.jpg "Set CMS default language")

@TODO

+ Language Switcher
+ Multi Language Url Rules
+ Crud i18n
+ Domain matching language
+ Composition add another pattern
+ Get current application language within controllers etc.