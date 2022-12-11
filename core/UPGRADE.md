LUYA UPGRADE
============

This document will help you upgrading from a LUYA Version into another. For more detailed informations about the breaking changes **click the issue detail link**, there you can examples of how to change your code.

## 2.3.0

+ [#2165](https://github.com/luyadev/luya/pull/2165) Official deprecated unit tests for php 7.0 and 7.1. The minium php version is now 7.2, see [php supported versions](https://www.php.net/supported-versions.php). The code keeps the same and should be backwards compatible but its not official tested anymore.

## 2.0.0

+ [#2068](https://github.com/luyadev/luya/issues/2068) In order to restore the auto register mechanism for csrf tokens either use `ActiveForms` or configure your component:

```php
$config->webComponent('view', [
    'autoRegisterCsrf' => true,
]);
```

But as long as you where using the `ActiveForm` class to generate your forms or either use `$this->registerCsrfMetaTags()` in your Controllers, this won't affect your application. When there is a form which does not work anymore, just add `$this->registerCsrfMetaTags()` in the controller action, f.e.

```php
$model = ...
$this->registerCsrfMetaTags();

return $this->render('form', [...]);
```

Read more about CSRF implementation in the [Yii Framework Security Guide](https://www.yiiframework.com/doc/guide/2.0/en/security-best-practices#avoiding-csrf).

+ [#2081](https://github.com/luyadev/luya/pull/2081) Removed deprecated methods and/or added a deprecation error trigger. Search and Replace:
  + `composition->language` new `composition->langShortCode`
  + `composition->get()` new `composition->getKeys()`
  + `composition->getFull()` (`composition->full`) new `composition->prefixPath`
  + Removed `luya\Boot::isCli()` use `luya\Boot::getIsCli()` instead
  + Removed `luya\behaviors\Encode` use `luya\behaviors\HtmlEncodeBehavior` instead.
  + Removed `luya\behaviors\Timestamp` use `luya\behaviors\TimestampBehavior` instead.
  + Removed `luya\web\Composition::EVENT_AFTER_SET` - no replacement
  + Removed `luya\web\CompositionAfterSetEvent` - no replacement

## 1.6.0

+ [#2037](https://github.com/luyadev/luya/issues/2037) The LazyLoad widget now surrounds the image with a wrapper class (that will have the extraClass applied), keep that in mind - you might need to tweak your CSS a little bit. By default this wrapper will then be replaced by the actual image tag (Option: `replacePlaceholder`).

## 1.0.21

+ [#1772](https://github.com/luyadev/luya/issues/1772) With the new support of `luya\Config` its recommend to switch to the new configuration of LUYA. The old system will still work, but its recommend to change the way how configs are stored and retrieved. Since version 1.0.21 its recommend to have a **single config file** called `config.php`. The config file could look like this 

```php
$config = new Config('testapp', dirname(__DIR__), [
    'siteTitle' => 'My Test App',
    'defaultRoute' => 'cms',
    'modules' => [
        'admin' => [
            'class' => 'luya\admin\Module',
            'secureLogin' => true,
        ],
        'cms' => [
            'class' => 'luya\cms\frontend\Module',
        ],
        'cmsadmin' => [
            'class' => 'luya\cms\admin\Module',
        ]
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'composition' => [
            'default' => [
                'langShortCode' => 'en'
            ],
            'hidden' => true,
        ],
    ],
    'bootstrap' => [
        'cms',
    ]
]);

$config->component('db', [
    'dsn' => 'mysql:host=LOCAL_HOST;dbname=LOCAL_NAME',
    'username' => 'LOCAL_USER',
    'password' => 'LOCAL_PW',
])->env(Config::ENV_LOCAL);

$config->component('db', [
    'dsn' => 'mysql:host=PROD_HOST;dbname=PROD_NAME',
    'username' => 'PROD_USER',
    'password' => 'PROD_PW',
])->env(Config::ENV_PROD);

$config->webComponent('request', [
    'cookieValidationKey' => 'XYZ',
]);

return $config;
```

The config file returns an instance of `luya\Config` therefore the `env.php` should now look like this:

```php
<?php

$config = include('config.php');

return $config->toArray([\luya\Config::ENV_LOCAL]);
```

1.0.0 (12. December 2017)
-------------------

> When upgrading from RC4 to 1.0.0 you have run the updater as we have moved all blocks into seperate repos: [https://github.com/luyadev/luya/issues/1572](https://github.com/luyadev/luya/issues/1572)

A few changes you will surely notice when upgrading to version 1.0.0 and you should check in your application:

+ [#1572](https://github.com/luyadev/luya/issues/1572) CMS blocks are now deliverd trough [generic](https://github.com/luyadev/luya-generic) and [bootstrap3](https://github.com/luyadev/luya-bootstrap3) repos. Register them in your composer.json file and run the updater `./luya cms/updater/generic` afterwards.
+ Storage file `source` is now `href`, even when `toArray()` is called, like in blocks and block admin twigs. (Search for `->source`, `'source'`, `"source"`, `.source`). Why? We follow semantic naming of html structure, therefource source points to webserver accessable file directory for the file or image, link instead is used to download files (link to a file).
+ Active Windows `alias` property is now `label`, so take a look at your `ngRestActiveWindows` config in your NgRest Models. (Search for `'alias'` or `"alias"`).
+ CMS Module property `enableCompression` renamed to `contentCompression`. Check your config file.

There are also few other changes, which are less significant, [see https://github.com/luyadev/luya/issues/1505](https://github.com/luyadev/luya/issues/1505)

1.0.0-RC4 (5. September 2017)
-------------------

When upgrading from RC3, we use the luya composer plugin to bootstrap the cms module. Sometimes you have to delete your vendor folder once and run composer update again.

```sh
rm -rf vendor && composer install
```

Now run the migrate and import commands

```php
./vendor/bin/luya migrate && ./vendor/bin/luya import
```

The next what you will notice is `Setting unknown property: luya\web\Application::luyaLanguage`, property `luyaLanguage` is not available anymore so remove this from your config. If you like to define the admin ui language to the admin module section in your config and use

```php
 'admin' => [
    'class' => 'luya\admin\Module',
    'interfaceLanguage' => 'en',
],
```

Low level API changes:

+ Mail component method `adresses()` is now correctly written as `addresses()`.
+ [#1408](https://github.com/luyadev/luya/issues/1408) THe CMS Module is now bootstraped over the luya composer plugin if you want explicit call the bootstrap process use `'bootstrap' => ['luya\cms\frontend\Bootstrap']` inside your config.
+ [#1414](https://github.com/luyadev/luya/issues/1414) Renamed Angular Helper methods, removed all the zaa prefixes.
+ [#1369](https://github.com/luyadev/luya/issues/1369) FlowActiveWindow dropped property `$modelClass` and does need to be configured anymore.
+ [#1308](https://github.com/luyadev/luya/issues/1308) A list of changed properties and methods.
- [#1448](https://github.com/luyadev/luya/issues/1448) Admin translations must be registered in Module::onLoad.

1.0.0-RC3 (11. April 2017)
-------------------

> The kickstarter now refers to the newest composer fxp entry, so make sure to add the new fxp config after run `composer global update`
> ```json
> "config": {
>     "fxp-asset" : {
>         "pattern-skip-version": "(-build|-patch)",
>         "installer-paths": {
>             "bower-asset-library": "vendor/bower"
>         }
>     }   
> }
> ```

If there is an error after the `migrate` command (missing column `title_tag`), unfortunately you will have to create this field manually in table `cms_nav_item`: name = `title_tag`, type = `varchar(200)`. This is due to migration preparations for 1.0.0 release. (Alternatively, you can delete all tables and then execute the `migrate` command. But be aware that you will loose all local data doing so. You can sync remote data with the `admin/proxy` command after the migrations have been executed.)

+ [#1127](https://github.com/luyadev/luya/issues/1127) Deprecated Methods, Classes and Properties.
+ [#1076](https://github.com/luyadev/luya/issues/1076) *ALL* your blocks now have to extend from luya\cms\base\PhpBlock. Twig blocks are deprecated! 
+ [#1127](https://github.com/luyadev/luya/issues/1127) The menu item `hasChildren()` has been droped is now a getter method use `getHasChildren()` or `hasChildren` instead.
+ [#1076](https://github.com/luyadev/luya/issues/1076) **TWIG IS DEPRECATED** The whole compont, as the cms blocks with twig are now depreacted, the twigjs admin output for blocks still works, all other code related to twig is not working anymore! In order to include to your project use: https://github.com/luyadev/luya-rc-legacy
+ [#1180](https://github.com/luyadev/luya/issues/1180) Replaced `luya\admin\ngrest\base\ActiveWindowView::callbackButton()` by widget `luya\admin\ngrest\aw\CallbackButtonWidget::widget()`.
+ [#1177](https://github.com/luyadev/luya/issues/1177) The elements.php for the luya\web\Elements component does new look for the elements.php inside the @app/views folder instead of @app.
+ [#1109](https://github.com/luyadev/luya/issues/1109) All blocks deliverd from the LUYA core modules are marked as `final` so you are not able to extend from those blocks. Make sure you extend from the `luya\cms\base\Block` class.
+ [#1244](https://github.com/luyadev/luya/issues/1244) When using the crawler module, the output of the controller changed to an ActiveDataProvider object instead of an array with results, see the crawler module readme.
+ [#1229](https://github.com/luyadev/luya/issues/1229) The ngRest CheckboxRelation plugin dropped the support for ActiveRecord object getters inside the labelTemplates, use the closure function inside the labelFields propertie instead. 
+ [#1229](https://github.com/luyadev/luya/issues/1229) When creating an ngRestPlugin the method `serviceData()` requires now an event parameter `serviceData($event)`.
- [#1231](https://github.com/luyadev/luya/issues/1231) Upgrade to Angular 1.6 therfore all custom angular admin js files have to make sure to be compatible with Version 1.6 (dropped .success and .error for $http component)

As we merged migrations files from older beta releases, you can find all delete files in the following [commit](https://github.com/luyadev/luya/commit/78f5304054be95ad317a80455587d8a4e0a0b9a8#diff-ecf9849552b303be6db5a3bd40029037).

1.0.0-RC2 (29. Nov 2016)
-----------------------

The issues below can lead into problems when upgrading to 1.0.0-RC2.

+ [#1070](https://github.com/luyadev/luya/issues/1070) Renamed methods of the block interface. Change `getBlockGroup()` to `blockGroup()`.
+ [#1058](https://github.com/luyadev/luya/issues/1058) Removed all massive assigned vars, cfgs, extras and placeholders from the PHP Block view.
+ [#1069](https://github.com/luyadev/luya/issues/1069) Removed CMS Block assets propertie in order to reduce RAM usage and follow Yii guidelines in order to register assets.
+ [#1068](https://github.com/luyadev/luya/issues/1068) Cms Block zaa() helper methods moved to \luya\cms\helpers\BlockHelper and marked methods as deprecated.
+ [#1045](https://github.com/luyadev/luya/issues/1045) Admin modules `getMenu()` method must return an `luya\admin\components\AdminMenuBuilder` object instead of an array. A deprecated message is triggered when using the old menu builder functions.
+ [#1067](https://github.com/luyadev/luya/issues/1067) The itemApi routes newls uses `/` (slashes) as delmiter instead of `-`: Old: `itemApi('label', 'admin-user-index')` new `itemApi('label', 'admin/user/index')` in your Module.php
+ [#1075](https://github.com/luyadev/luya/issues/1075) Frontend and Admin Controller and Module assets can not be stored in the `$assets` property of a module or controller any more.

1.0.0-RC1 (04.10.2016)
-----------

As part of this release all module will be renamed. Frontend and admin module will be merged together. All module classes will get the prefix `luya`. So in order to upgrade your current modules, filters, blocks, blockgroups, models, etc. you have to rename a lot of classes of your project files:

|old    |new
|---    |---
|`cmsadmin\...`|`luya\cms\admin\...`
|`cms\...`|`luya\cms\frontend\...`
|`admin\...`|`luya\admin\...`

Search and replace examples:

|search     |replace
|---        |---
|`cms\helpers\TagParser`|`luya\TagParser`
|`cms\helpers\Url`|`luya\cms\helpers\Url`
|`cmsadmin\base\Block`|`luya\cms\base\TwigBlock`
|`\admin\ngrest\base\Api`|`\luya\admin\ngrest\base\Api`
|`\admin\Module`|`\luya\admin\Module`
|`\admin\ngrest\base\Model`|`\luya\admin\ngrest\base\NgRestModel`
|`\admin\ngrest\base\Controller`|`\luya\admin\ngrest\base\Controller`
|`\admin\base\Filter`|`\luya\admin\base\Filter`
|`\admin\base\RestController`|`\luya\admin\base\RestController`
|`\admin\base\Controller`|`\luya\admin\base\Controller`
|`\admin\ngrest\base\ActiveWindow`|`\luya\admin\ngrest\base\ActiveWindow`


* [#970](https://github.com/luyadev/luya/issues/970): Renamed rest classes `luya\rest\BehaviorInterface`, `luya\rest\BehaviorTrait`, `luya\rest\BaseActiveController`
* [#972](https://github.com/luyadev/luya/issues/972): Renamed all modules to match luya prefix as described from the table above.
* `#976`: Removed `$isCoreModule` property, replaced width `CoreModuleInterface`.
* `#974`: Removed `$isAdmin` property, replaced with `AdminModuleInterface`.
* `#875`: TagParser has been renamed to `luya\TagParser` instead of `cms\helpers\TagParser` and is now a core class.
* [#806](https://github.com/luyadev/luya/issues/806#issuecomment-248597369): Renamed to `configs/server.php` to `configs/env.php`, new projects will also have the env prefix for the config names.

### Update tag for internal links
The tag for internal links has changed from `link[32]` (where 32 is the id of the linked page) to `menu[32]`. To replace all occurrences, you can search and replace within the field `json_config_values`of the table `cms_nav_item_page_block_item` with the following regular expression:

Search for: `link\[([0-9]+)\]`  
Replace with: `menu[$1]`

Be sure to make a backup of the database beforehand!


1.0.0-beta8 (11.08.2016)
-----------

* [#940](https://github.com/luyadev/luya/issues/940): The `admin\base\Filter` class for all filters requers now a **public static identifier()** method instead of a *none static* method.
* [#907](https://github.com/luyadev/luya/issues/907): Removed the public attribute `$extraFields` in order to prevent confusings. Override `extraFields()` instead in `admin\ngrest\base\Model`.


1.0.0-beta7 (released 20.06.2016)
-----------

* `#860`: As part of using the Yii2 imagine Extension we removed the `Resize`-Effect Filter chain and renamed the `Thumbnail`-Effect option `type` to `mode`.
* `#877`: *all* NgRest base model does have function `public function ngRestApiEndpoint()` and defines the api endpoint. This method is now **static**. So use `public static function ngRestApiEndpoint()` instead.
* `#875`: As part of the tag Parser rework, the helper method to parse luya tags (links, etc.) `cms\helpers\Parser::encode($text)` has been changed to `cms\helpers\TagParser::convert($text)`.


1.0.0-beta6 (released 21.04.2016)
-----------

**We have moved all repositories to the new HQ of LUYA, `luyadev` instead of `zephir`. In order to to update your packages, remove `zephir` and replace with `luyadev` in your composer require section.**

* `#833`: Command controller in console is deprecated use default route behavior instead `module/controller/action`, run action will find the module commands namespace controllers if available in the config.

* `#818`: Since 1.0.0-beta6 we have added the versions concept of luya pages you have to run once the command `./vendor/bin/luya cmsadmin/updater/versions` **after executing the migration** process.

* `#807`: The NgRest plugin system has been rewritten to use the yii component base class, as therefore some plugin configuration has changed as the are not using the constructor any more instead are configurable via base object of the class properties. changes:
   - `selectClass` has ben renamed to `selectModel`.
   - constructor calls are not allowed and has to be defined as following:
       - ['selectModel', 'modelClass' => path\to\Genres::className(), 'valueField' => 'id', 'labelField' => 'title']]
       - ['selectArray', 'data' => [1 => 'Male', 2 => 'Female']]
       - ['checkboxList', 'data' => [1 => 'Male', 2 => 'Female']]
       - ['checkboxRelation', 'model' => User::className(), 'refJoinTable' => 'admin_user_group', 'refModelPkId' => 'group_id', 'refJoinPkId' => 'user_id', 'labelFields' => ['firstname', 'lastname', 'email'], 'labelTemplate' =>  '%s %s (%s)']
* `#758`: Due to replacement of twig, cms layout files must be a phpfile instead of a twig file. The following file `main.twig` would be new `main.php`, file content compare:
  old:
  ```twig
  <div>{{placeholders.content}}</div>
  ```
  
  new:
  ```php
  <div><?= $placeholders['content']; ?></div>
  ```
* `#771`: As we have removed the LUYA module as module and use it as library you have to remove the `luya\Module` in your application. But when you are using the *CMS-Module* you must [bootstrap](https://www.yiiframework.com/doc-2.0/guide-runtime-bootstrapping.html) it instead, by adding a new entry in your application config settings:
  ```php
  'bootstrap' => [
      'cms',
  ],
  ```
* `#809`: Soft delete admin trait public static method `SoftDeleteValues` has ben renamed to `FieldStateDescriber`.
* `#791`: As we removed the LUYA module, the luya core library is now availabel trough the composer package `luyadev/luya-core` instead of using `zephir/luya`. You can also remove the luya composer package from your require section as it should be defined as dependencie of the modules. As part of this change you now have to `bootstrap` the cms module in the bootstrap section of your config.
* `#780`: In terms of Yii2 controller view render behavior consistency:
  - removed `$useModuleViewPath` property of `luya\web\Controller`.
  - removed `$controllerUseModuleViewPath` property of `luya\base\Module` replaced with `$useAppViewPath`.
* `#777` The suffix (ActiveWindow) is now removed from the folders where the view files are located:
  - before: `MyTestActiveWindow` folder for view files: `views/<locator>/mytestactivewindow`
  - after: `MyTestActiveWindow` folder for view files: `views/<locator>/mytest`.

* `#822`: `#822` zaa-checkbox-array renamed variables.
    ```
    changed options from zaa-checkbox-array in ngrest directive from:

    options.items[] = { "id" : 1, "value" => 'Label for Value 1' }
    
    to:
    
    options.items[] = { "value" : 1, "label" => 'Label for Value 1' }
    ```
