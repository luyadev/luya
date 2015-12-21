LUYA CHANGELOG
==============

1.0.0-beta3 (in progress)
-------------------------

**BC BREAKS**

- `#663` **Removed `admin\storage\FileQuery`, `admin\storage\ImageQuery`, `admin\storage\FolderQuery` and replace with `admin\file\Query`, `admin\image\Query`, `admin\folder\Query`.**

**ISSUES**

- `#653` Added storage consistency check to import and the new storage/cleanup console command
- `#652` Added ability to reset/clear image and file uploads in directives.
- `#646` Added a link block with the possibility of linking to internal pages and external target.
- `#650` Updated styling; Updated old (materialize) toast calls (replaced with new ones)
- `#660` Updated spacing; Replaced arrows
- `#662` Rearrange zaa-table option icons and added auto-scroll to table
- `#654` Added border to file- and image-array, added fix break between text and button at the ImageTextBlock, added additional configuration on LinkButtonBlock and some missing translations.
- `#648` fixed bug where ajax block callback have no composition prefix.
- `#637` fixed issue where image upload does not change ng-model when image already exists in image data list.
- `#638` fixed issue where menu component does not use `createRouteEnsure`.
- `#634` added getContainer and getLevelCurrentItems for menu component.
- `#633` added the ability to register new translations/message quickly in the Module.php via $translation property.
- `#643` added ability to get cms menu item siblings.
- `#644` added ability to get all menu items for a specific level `getLevelContainer` in menu component.
- `#639` added missing translations for divider line block.
- `#158` added ability to sort the items in list block.
- `#425` added ability to move columnds and rows up/down in table block.
- `#647` added image delete helpers to admin storage helper.
- `#449` added toast service with confirmations.
- `#484` added toast service with error and success messages.
- `#649` added maxlength for text input fields of 255 chars (on zaa-text).
- `#651` fixed issue where image and file list array where unable to be i18n casted.
- `#659` fixed security issue for ngrest callbacks.
- `#658` fixed composition rules issue where parse request creates absolut urls.
- `#661` added block helper methods (prefix with zaa) to get file/s and image/s data.
- `#663` renamed storage query classes, added findImage, findFolder and findFile.

1.0.0-beta2 (3.12.2015)
-------------------------

- **[BC BREAK]** removed $app->storage component and replaced with new storage $app->component see api guide.
- **[BC BREAK]** removed luya\web\Composition::set method.
- `#619` Blocktoolbar displaying now always all possible icons
- `#620` Switched background-color of the layout-labels from white to deeporagne
- `#616` create default page on setup command.
- `#615` added ability to make luya internal luya translations.
- `#614` updated treeview styling to improve ux
- `#612` added headline and link-button to imagetextblock cfgs
- `#607` added new audio-block for soundcloud embeded player
- `#609` added new link-button-block
- `#608` added new block for a simple horizontal line
- `#601` added cancel/clear option to the block search field
- `#600` added LuyaLoading service to start and stop loading overlay.
- `#605` fixed issue where cms layout labels have been overriden on every import process.
- `#600` generalized filemanger loading overlay to .loading-overlay. This overlay can now be used context-independent.
- `#501` removed for / id assignment and resolved issue with ng-click=""
- `#599` added basic styling for help boxes. Simple question mark icon that shows belonging text on hover. 
- `#539` added possiblity to delete tags under `cmsadmin/system/tags`.
- `#370` added block importer consistency check and delete all remaining block references.
- `#572` removed font-awesome from ng-wig css. Replaced them with material-icons.
- `#491` added the ability to toggle the visibility of a cms block (is_hidden).
- `#584` fixed bug where preview link does not handle language correct. Moved language handler into composition component and added new event class.
- `#582` fixed issue where file downlaod links does not work on multi lingual pages, moved route resolver into urlManager instead of luya urlRule.
- `#588` delete the block cache (for the specific block) after updating them via cms admin.
- `#487` added URL duplication check (alias) on page move.
- `#540` fixed bug where you could create empty tags
- `#508` show target path for redirected pages in admin.
- `#583` added ability to make cms page drafts and re-use them when creating a new page.
- `#586` added additional help info to blocks where it appeared relevant.
- `#585` replacing text field with a select in ModuleBlock (only show frontend modules except 'luya' and 'cms').
- `#576` modified crawler search proccess to process word by word searches instead of full text searches.
- `#580` added ability to create composition routes, fixes the prepend language issue for menu component.
- `#575` added the ability to cache cms blocks.
- `#559` added new block method `getFieldHelp()` to return additional helper data for a var or cfg field.
- `#489` added the ability to drop pages on empty navigation containers.
- `#509` improved video block (added Vimeo).
- `#574` added strftime twig filter to get date formats based on the current localisation settings.
- `#558` added image thumbnail in list view for image plugin, therefore added storageImageThumbnailDisplay directive.
- `#533` file- and image-array directive removed margin-top for better alignment to the labels 
- `#568` added menu query component `offset()`, `limit()` and `count()` methods to slice or count the data.
- `#565` added icon when page is the default home page in cms admin side tree.
- `#567` added menu informations about update and insert timestamp and user. added: getDateCreated(), getDateUpdated(), getUserCreated(), getUserUpdated() to menu item object.
- `#566` added description field for the cms admin and getDescription() on menu item. Is automatically registering meta description and og:description.
- `#534` added support for the original file names, introduced with new storage system.
- `#477` added singleton storage component to reduce the number of sql request for large sites.
- `#570` menu component home link contains relative slash to make valid links.
- `#542` added file size to filemanager.
- `#546` Page-property-icon: Removed empty space of the button if the page has no property.
- `#535` Filemanager: Move-buttons use now default-button-style.
- `#527` directory-names in filemanager full displayed.
- `#536` switched color for inactive state langauge-button.
- `#522` added styles for checkbox filtering.
- `#507` added new twig functions to luya guide.
- `#538` fixed issue where new directories are not displayed in overlay mode.
- `#537` added ability to preview and download the file/image inside the filemanager.
- `#531` unable to deselect language, as at least 1 langauge must be active in admin module.
- `#528` sorting filemanager folders by name.
- `#412` fixed bug where ObjectHelper::callMethodSanitizeArguments does not handle optional arguments.
- `#526` added publicHtml getter to web controller and twig variable publicHtml.
- `#562` added exception when cms layout variable is not a valid name (a-zA-Z0-9) on import process.
- `#589` Updated treeview styling
- `#594` Updated ngrest plugin SelectClass to enable the possibility to choose 'nothing'

1.0.0-beta1 (11. Nov 2015)
-------------------------
- **[BC BREAK]** removed `luya\helpers\Url::toModule()` replace with `cms\helpers\Url::toMenuItem()`.
- **[BC BREAK]** removed `Url::to()` an replaced with `Url::toManager()`, extended url helper from yii helper to provide native functionality.
- **[BC BREAK]** removed the `links`component and replace with the `menu` component.
- **[BC BREAK]** `#391` removed home site resolving through cms_cat, replaced with is_home state in cms_nav.
- **[BC BREAK]** `#219` old mdi-* icons are not working anymore, updated to new materialize icon font.
- **[BC BREAK]** `#344` zaa-checkbox-array value describer `id` is replaced by `value` to be consistent
- renamed `cms_cat` table into `cms_nav_container`.
- removed `rewrite` fields in cms_nav_item and cms_cat and replaced with `alias` field.
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
