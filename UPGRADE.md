LUYA UPGRADE
============

This document will help you upgrading from a LUYA Version into another. For more detailed informations about the breaking changes **click the issue detail link**, there you can examples of how to change your code.

1.0.0 (in progress)
-------------------

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

If there is an error after the migrate command (missing column `title_tag`) sadly you have to create this field manual in table `cms_nav_item` name `title_tag` type `varchar(200)`. This is due to migration prepare for 1.0.0 release.

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
* `#771`: As we have removed the LUYA module as module and use it as library you have to remove the `luya\Module` in your application. But when you are using the *CMS-Module* you must [bootstrap](http://www.yiiframework.com/doc-2.0/guide-runtime-bootstrapping.html) it instead, by adding a new entry in your application config settings:
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
