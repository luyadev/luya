LUYA UPGRADE
============

This document will help you upgrading from one LUYA Version into another

1.0.0-beta6
-----------

**We have moved all repositories to the new HQ of LUYA, `luyadev` instead of `zephir`. In order to to update your packages, remove `zephir` and replace with `luyadev` in your composer require section.**

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

* `#791`: As we removed the LUYA module, the luya core library is now availabel trough the composer package `luyadev/luya-core` instead of using `zephir/luya`. You can also remove the luya composer package from your require section as it should be defined as dependencie of the modules.

* `#780`: In terms of Yii2 controller view render behavior consistency:
  - removed `$useModuleViewPath` property of `luya\web\Controller`.
  - removed `$controllerUseModuleViewPath` property of `luya\base\Module` replaced with `$useAppViewPath`.

* `#777` The suffix (ActiveWindow) is now removed from the folders where the view files are located:
  - before: `MyTestActiveWindow` folder for view files: `views/<locator>/mytestactivewindow`
  - after: `MyTestActiveWindow` folder for view files: `views/<locator>/mytest`.
