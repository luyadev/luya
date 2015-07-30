LUYA CHANGELOG
==============

1.0.0-alpha14 (in progress)
---------------------------
- added `cms\helpers\Url`.
- added crawler moudle frontend controllers *DefaultController* and *RestController*.
- fixed bug [a76eaf0](https://github.com/zephir/luya/commit/f89af2f4e3fe83de5cc154870ee9a48e636d32e6) where request get params are not bound to action when loading a module via `module/Reflection.php`.

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
