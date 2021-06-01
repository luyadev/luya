# Languages

LUYA provides a powerful multi language support as we have focused on multi lingual website very strong during the concept and development phase. In order to understand how to configure your site to fit your needs read the section below.

Keep in mind that the `language` property of your application is the main setting for the Yii translation system.

## How to configure

As LUYA is developed as a modular system the languages must be configured in several parts of the system. The multi lingual support works with or without cms.

There is a component known as [composition component](concept-composition.md) which is dealing with the language settings. The component is invoked by the application boot process and changes the base url inside the urlManager based on your configuration. If the composition is actived and not hidden it will manipulate the {{yii\base\Application::$language}}. So it can override your language from the configuration.

You always have to define the default language of your application configs:

```php
'composition' => [
    'hidden' => true,
    'default' => ['langShortCode' => 'en'],
],
```

+ {{luya\web\Composition::$hidden}}: (boolean) If this website is not multi lingual you can hide the composition, other whise you have to enable this.
+ {{luya\web\Composition::$default}}: (array) Contains the default setup for the current language, this must match your language system configuration.

Now you have set the default language of the application to **en** and the language prefix is available and will be appended to all urls. If hidden is enabled, it would still set the language, but would not prepend the string ot every url.

When using the CMS Module the configuration must match your configuration of the system languages (which is stored in the database) below a screen shot where the language short code *en* is set as *default language*:

![set-default-language](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/set-default-language.png "Set CMS default language")

## Retrieve current language

There are two ways to retrieve the current active language:

|Method|Example Value|Description
|------|-------------|----------
|`Yii::$app->composition->langShortCode`|`en`|As the name already tells, it will return the current language **short code** of the current page. Depending on the composition and language table configuration.
|`Yii::$app->language`|`en_EN`|Returns the i18n localisation value defined from locales.

## Localisation with locales

> Instead of using the locales system, we recommend you to make usage of the php intl extension, which is commonly available. Therfore f.e you use `Yii::$app->formatter->asDateTime($time, 'MMMM yyyy')` instead of  `strftime("%B %Y", $date);`. Take a look at the formating syntax here http://userguide.icu-project.org/formatparse/datetime

As the composition component can override the {{yii\base\Application::$language}} which is the base property for all translations within a Yii system you can define localisations for each language. Localisation are usually set trough setlocale() this is what LUYA does in the {{luya\traits\ApplicationTrait}}. You can define a localisation file for each language with the {{luya\traits\ApplicationTrait::$locales}} property, for example when language `de` is given it should take the `de_CH.utf8` locale file:

```php
'locales' => [
    'de' => 'de_CH.utf8',
    'en' => 'en_GB.utf8',
],
```

This is configured in the root level of your application config.

## Domain Mapping

In order to map a given domain to language use {{luya\web\Composition::$hostInfoMapping}}:

```php
'hostInfoMapping' => [
    'http://example.us' => ['langShortCode' => 'en', 'countryShortCode' => 'us'],
    'http://example.co.uk' => ['langShortCode' => 'en', 'countryShortCode' => 'uk'],
    'http://example.de' => ['langShortCode' => 'de', 'countryShortCode' => 'de'],
],
```

## Localisation prefix

```php
'pattern' => '<langShortCode:[a-z]{2}>-<countryShortCode:[a-z]{2}>',
'default' => [
    'countryShortCode' => 'us',
    'langShortCode' => 'en',
],
```

In order to retrieve data from the composition component you can access the composition component by its keys:

```php
$langShortCode = Yii::$app->composition['langShortCode'];
$countryShortCode = Yii::$app->composition['countryShortCode'];
```

## Language Parameter for APIs

Since version 3.1 of LUYA Admin the [ConentNegotiator](https://www.yiiframework.com/doc/api/2.0/yii-filters-contentnegotiator) correctly receives all available LUYA Admin languages. For instance, when you have setup `fr`, `de` and `en`, then the ContentNegotiator will listen to `Vary` `Accept` or `Accept-Language` Header, as well for `_lang` get param. If the content negotiator can detected one of the given languages in those methods, the `Yii::$app->language` will recieve this value, which will also be used to deocde/encode {{luya\admin\ngrest\base\NgRestModel::$i18n}} attributes.

In consequences, this also means that the {{luya\web\Composition}} localisation in the URL (f.e. `de/foobar`) has no effect when working with APIs, either use HTTP Headers or `_lang` get parameter. In order restore the behavior before 3.1 which has taken the composition language path into account, you can configure {{luya\admin\components\AdminLanguage::$activeShortCodeCallable}}, but its not recommended.

## Other language related topics

+ [[app-translation.md]] - Register and create message files.
+ {{luya\cms\widgets\LangSwitcher}} - A widget to switch between languages.
+ {{luya\admin\ngrest\base\NgRestModel::$i18n}} - Option to enable i18n for ngrest models.
