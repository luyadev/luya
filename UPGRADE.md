LUYA UPGRADE
============

This document will help you upgrading from one LUYA Version into another

1.0.0-beta6
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