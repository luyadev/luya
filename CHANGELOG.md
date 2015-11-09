LUYA CHANGELOG
==============

1.0.0-beta1 (in progress)
-------------------------
- **[BC BREAK]** removed `luya\helpers\Url::toModule()` replace with `cms\helpers\Url::toMenuItem()`.
- **[BC BREAK]** removed `Url::to()` an replaced with `Url::toManager()`, extended url helper from yii helper to provide native functionality.
- **[BC BREAK]** removed the `links`component and replace with the `menu` component.
- **[BC BREAK]** `#391` removed home site resolving through cms_cat, replaced with is_home state in cms_nav.
- **[BC BREAK]** `#219` old mdi-* icons are not working anymore, updated to new materialize icon font.
- **[BC BREAK]** `#344` zaa-checkbox-array value describer `id` is replaced by `value` to be consistent
- added luya admin tag active window `$config->aw->register(new \admin\aws\TagActiveWindow(static::tableName()), 'Tags');`.
- added ngrest list color plugin.
- added cmsadmin ability to redirect to internal pages.
- added ability to register asset class inside a block
- added ability to create block ajax requests with callbacks.
- added ability to add rewrite if not existing in same navigation level.
- added clear cache and reload button
- added ability to set queue list position index for importer classes.
- added smtp test cli `health/mailer` to test SMTP connection.
- added two-way factor auth via E-Mail when enabling `$secureLogin` in admin module.
- added cli user creation command `setup/user`.
- added cms logging table to track all events (insert,update,delete) on nav, nav_item and blocks.
- added new cms\helpers\Url method toModuleRoute which combines url creation from a module which is implemented via cms.
- added file helper \luya\helpers\FileHelper humanReadableFilesize method.

1.0.0-alpha20 (8. Okt 2015)
---------------------------
- changed form table styles
- removed ngrest crud modal dialogs, added tabs
- added property events binding
- added module property `public $isCoreModule` to hide modules for user selections.
- fixed several small bugs with ngrest configs and i18n fields.
- added basic implementation of admin and cms page properties.
- changed behavior of the links component: is_hidden pages are accessable but hidden in navigation; is_offline pages are not accessable by both.
- added is_offline property to cms_nav
- important bug fix where language composition prefix does not find default page in other languages.
- rewritten links component to fix bug with mutli lingual navigations.

1.0.0-alpha19 (16. Sept 2015)
---------------------------
- change ngRestAfterFind behavior.
- removed effect creation on setup process, moved to filter importer.
- added admin_config to set get values.
- added health command
- fixed exit code return output in console commands.
- basic ngrest config class integration
- remote token security fix
- added aws close buttons (unstyled)
- added luya bin file `./vendor/bin/luya` to execute console commands. Will remove ability to execute console commands against index.php

1.0.0-alpha18 (2. Sept 2015)
---------------------------
- [eb8ac28b1eb9587af00a990fd80ac5879f07ec51](https://github.com/zephir/luya/commit/eb8ac28b1eb9587af00a990fd80ac5879f07ec51) *[HOTFIX]* Bug in reflection Module block fixed.

1.0.0-alpha17 (2. Sept 2015)
---------------------------
- [39a6aaf](https://github.com/zephir/luya/commit/39a6aaf24ba9a6cc6e33615b085d0f4c409b7286) added *Element Component* to build structured html element data.
- [07a2372](https://github.com/zephir/luya/commit/07a2372191cf36e8f4a16ac99ac4ecf4cdb5fdf0) *[BC BREAK]* removed commands `exec/import` and `exec/setup` replace with `import` and `setup` (without exec). Fully rewritten importer process.
- [30c1af3](https://github.com/zephir/luya/commit/30c1af35cc9f900145e1e5f9abb5e5cca1eeee57) changed reflection class handling. Move getRequestResponse out of responseContent method.
- fixed bug where modules without namespace of the module are not able to load. fixed by using getNamespace() method for each module.
- twig update to `1.21.0`
- added ability to disable compression of cms content output with `$enableCompression = false`. 
- rewritten testing structure.

1.0.0-alpha16 (18. Aug 2015)
---------------------------
- Faster frontend loading, faster ngRest Module, ngRestConfig update.
- [445ff99](https://github.com/zephir/luya/commit/445ff99e121feac2928aa121830ba53df987e249) *[BC BREAK]* Made base classes abstract, changed `luya\base\Boot` to `luya\Boot`, moved traits out of base folder.
- [3a820ce](https://github.com/zephir/luya/commit/3a820ce59c44e294f3a77e253dc68a5a988e8118) total rewritten ngrest/Config, added ngrest/ConfigBuilder, added unitTests.
- [bb66c16](https://github.com/zephir/luya/commit/bb66c1641a5465c61e7731fbcef028bcecfbbfc1) moving composition into luya components.

1.0.0-alpha15 (11. Aug 2015)
---------------------------

**Database upgrade 1.0.0-alpha15-upgrade.sql**

- [#296](https://github.com/zephir/luya/issues/296) added ability to set no filter selection in image upload Plugin `image(false)` in `ngRestConfig()`.
- [#327](https://github.com/zephir/luya/issues/327) fixed bug where i18n select model labels are _ngrestCall behavior appended, see if label is an array an return first occurrence.
- [#323](https://github.com/zephir/luya/issues/323) fixed bug where checkboxReleation id have not been delivered.
- [#309](https://github.com/zephir/luya/issues/309) added ability to remove and move files in filemanager.
- [e931b01](https://github.com/zephir/luya/commit/e931b01df0954c1d9e404eda80864ee4f1e2e036) added ability to rename folders in filemanager.
- [d22ddc7](https://github.com/zephir/luya/commit/d22ddc76e203a1200bf33bb3f9bc089eb74c5db4) changed NgRest `ToggleStatus()` plugin for CRUD list display from 0/1 to check mark/cross.
- [#315](https://github.com/zephir/luya/issues/315) added ngrest plugin `checkboxRelation` display array parameters and render template string.
- [5eceab0](https://github.com/zephir/luya/commit/5eceab0efd7e23e0a66c1f84d8f2bdabc1d71d87) added ability to search for element blocks inside cms.
- [51fca3d](https://github.com/zephir/luya/commit/51fca3ddafb8c4e55d3f460b76b21e9f839a49b2) fixed bug in link creation (createUrl), where url creation now replaces only the first occurrence in context mode.
- [08aded0](https://github.com/zephir/luya/commit/08aded018e0a42df190895bb4156cebffd4fef12) upgrade to yii version `2.0.6`.
- [48d2b9d](https://github.com/zephir/luya/commit/48d2b9dac8851ef1bd3d8c0c564d5d49def36520) added new `zaaTable` and `TableBlock` class.

1.0.0-alpha14 (3. Aug 2015)
---------------------------
- `#297`: added storage image component `getSource($imageId)` (`Yii::$app->storage->image->getSource(9)`).
- added `cms\helpers\Url`.
- added crawler module frontend controllers *DefaultController* and *RestController*.
- [a76eaf0](https://github.com/zephir/luya/commit/f89af2f4e3fe83de5cc154870ee9a48e636d32e6) fixed bug where request get params are not bound to action when loading a module via `module/Reflection.php`.
- [a5d418c](https://github.com/zephir/luya/commit/2bd81a52a339527d8cfb0190de38a94ab004dfad) fixed bug in link creation (createUrl), where url creation now replaces only the first occurrence.

1.0.0-alpha13 (30. Jul 2015)
--------------------------
- `storage->image->filterApply` does not return the image object by default anymore. Default return value is the source of the image object, to force the image object response us `true` as 3rd param.
- added remote informations api
- `#282`: display error messages from ActiveRecord via RestActiveController.
- `#283`: display confirm message on delete.

1.0.0-alpha12 (22. Jul 2015)
----------------------------
- hotfix: Fixed bug where page create scenarion failed.

1.0.0-alpha11 (21. Jul 2015)
---------------------------
- fixed bug where `$_context` variable was not written correctly in module reflection loader.
- `#257`: filemanager rows are now selectable.
- `#246`: display arrow when no blocks have been dropped yet.
- `#271`: removed twig function `linkActive()` added global variable `activeUrl`.
- `#244`: removed NgRest `required()` plugin.
- `#215`: removed `luya\base\PageController` and replace with basic `luya\base\Controller`. `$this->context->pageTitle` is now invalid.
- `#221`: removed `presql` command and replaced with `migrate` command.
- `#214`: removed fake behavior renderLayout, replaced with yii layout similar behvaior using `$content` and requred `$viewFile` param.

1.0.0-alpha10 (9. Jul 2015)
---------------------------
- Added News-Module fields
- `#222`: added `module/create` cli command.
- `#245`: fixed empty values in cms page creation.
- `#235`: fixed bug where modal windows where to small.
- `#228`: fixed bug where initvalue in select directives does not work for integer values.
- `#220`: improved filemanager, removed ng-flow, added native angular-uploader.
- `#218`: improved NgRest Crud permission verifications (API Permissions).

1.0.0-alpha9 (8. Jul 2015)
--------------------------
- `#196`: removed `$links->activeLink` and replaced with `$links->activeUrl`.
- `#212`: renamed `config` folder into `configs` as default value.
- `#183`: added ability to remove items in `NgRest`. Just add `$config->delete = true` inside your `NgRestConfig()` method.

1.0.0-alpha8 (30. Jun 2015)
--------------------------
- fixed bug in links component `getLink($link)` returns false.
- added `hasLink($link)` to links component.
- added `#131` Admin search data tracking.
- fixed `#165` Logout-Button Firefox issue.
- fixed `#156` Max field width..
- fixed `#155` Added ng-cloak.
- fixed `#151` Verify cmslayouts placeholders on import, compare placeholders.
- fixed `#147` Hide fields when creating page.
- fixed `#143` Added placeholder and initvalue.
- fixed `#138` Mail componentend extended.
- fixed `#132` Added cms pages to global search.
- implemented `#131` Track search querys.
- fixed `#129` Placeholder in var types.
- implemented `#126` Config block styling.
- implemented `#123` Dashboard styling.
- fixed `#121` Globlal search design.
- fixed `#116` Bigger thumbnail images in file manager.
- fixed `#115` Placeholders should not close on block insert.
- implemented `#105` Language services.
- implemented `#71` Useronline styling.
- fixed `#46` Textarea height on focus.

1.0.0-alpha7 (25. Jun 2015)
--------------------------
- fixed bug in UrlManager where components are not available.
- fixed bug where modules are loaded in the module integration block.
- added auth cleanup routine when using exec/import.

1.0.0-alpha6 (24. Jun 2015)
--------------------------
- removed `$app->collection->links` (search for `$app->collection->links` and replace with `$app->links`).
- removed `$app->collection->composition` (search for `$app->collection->composition` and replace with `$app->collection`).
- removed `admin\Module::getData()` added `$app->adminuser`.
- added luya version constante to module `luya\Module::VERSION`.
- added user online overview in admin panel.
- fixed `#64` wrong logout url.
- fixed `#65` Unclear text field focus in login form.
- fixed `#66` set focus in login form.
- new asset handling.
- disallow cms rewrite where a module with the same name exists.
- fixed loading bar visibility bug.
- updated sidebar / treeview title styles.
- implemented `#60` alert css styles.
- cms admin create inline page (language page for existing page).
- cms admin added sortable navigation tree.
- cms admin added slugable rewrite creation while typing.
- added `is_dirty` block.
- fixed bug in get block where extra vars have not been reloaded.
- added preview button.
- added `full_url` key in links array where the composition full url responses.

1.0.0-alpha5 (17. Jun 2015)
-------------------------------
- added new `serviceData()` method for ngrest plugins.
- module dashboard sort by date.
- cms admin placeholder do not close after insert/resport block.
- fixed `#51` itemRoute issue added permission guide.
- moved blockholder from bottom to right side / added toggle button for blockholder.
- Fixed overflow bug in sidebar.
- Fixed `#56` display current active sort arrow.
