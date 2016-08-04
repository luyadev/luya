LUYA CHANGELOG
==============

The changelog contains informations about bug fixes, new features or bc breaking code related to a GitHub issue. In order to read more about upgrading and BC breaks have a look at the [UPGRADE Document](UPGRADE.md).

1.0.0-beta8 (in progress)
-------------------------

- `#907`: **[BC BREAK]** Removed the public attribute `$extraFields` in order to prevent confusings. Override `extraFields()` instead in `admin\ngrest\base\Model`.
- `#836` Fixed slow processing of unneeded/orphaned files and database storage entries in StorageImporter
- `#742` Fixed parsing bug for youtube URLs with additional parameters in video block
- `#882` Added information to documentation about the 'only' publish options
- `#898` Fixed bug where filters dependencie in image thumbnail directive does not get resolved and result in js error.
- `#902` Fixed bug where version blocks can not update its parent nav item object.
- `#918` Fixed bug where TagParser and Markdown conflicting http url/link parsing.
- `#920` Fixed bug where i18n image/file array lists have wrong default value, array expected string given.
- `#926` Fixed bug where kickstarter template is missing jquery, fixed by depending on yii\web\JqueryAsset.
- `#927` Fixed bug where Datetime/Date directive contains preseleced values (added date picker and time directice renewal).
- `#929` Fixed bug where caching does not load new data when changing the layout of a cms page.
- `#906` Added silent mode for the LUYA setup process.
- `#786` Added ability to retriev context informations from a block like, index, last, first, nextEqual, prevEqual.
- `#908` Added ability to set ngRestFilters the specific grid list data where conditions.
- `#911` Added ability to set default sorting/ordering for grid list data in ngrest model.
- `#912` Added ability to set angular successfull save/update callbacks in order to trigger reloads of lists.
- `#913` Added ability to group fields into groups in the ngrest model in order to make cleaner forms.
- `#914` Added ability to group by a field in the crud data grid list overview.
- `#894` Added ability to remove an existing page version.
- `#820` Added ability to collect and evulate properties over menu component.
- `#925` Added ability to override default localisations for composition pattern by using `$locales` public method in composition component.
- `#928` Added ability to use PHP Views in Blocks.
- `#938` Added ability to hide specific cms blocks in the content manager by define them in the config.
- `#939` Added ability to toggle block groups and favorize blocks.
- `#800` Added ability to store the last directory of the filemanager in the user settings via ServiceFoldersDirecotryId service.
- `#905` Added ability to inject custom ngrest plugin for an appliation specific desinged approach.


1.0.0-beta7 (20.06.2016)
-------------------------

**BC BREAKS** See [UPGRADE.md](UPGRADE.md) as we have made some backward compatibility breaks in this release.

- `#860` **[BC BREAK]** Using Yii2 imagine extension instead of native imagine extension in order to fix memory leaks and optimize thumbnail/crop calculations.
- `#877` **[BC BREAK]** Changing the `ngRestApiEndpoint` method to static. Use `public static function ngRestApiEndpoint()`.
- `#875` **[BC BREAK]** cms\helpers\Parser::encode() renmaed to cms\helpers\TagParser::conver()
- `#896` Change exception for not found file downloads in order to skip exception transfer.
- `#888` Added FlowActiveWindow in order to add big image uploads without using the filemanager, allows chuck upload.
- `#885` Updated markup and styles to improve display of caption form in filemanager
- `#723` Removed loading-bar.css from BowerVendor
- `#878` Increased z-index for toast messages
- `#880` Fixed copy/paste layout block recursion problem.
- `#831` Close the propertie mask after saving/updating propertie values.
- `#578` Added new sort relation plugin as requested to make relations with sortable data from model or array.
- `#876` Improved textarea styling in zaa-table.
- `#863` Fixed behavior of module controller layouts when using in cms context.
- `#839` Styled the form search input.
- `#856` Styled the new is Homepage indicator. Added check_circle in green.
- `#857` Improved responsive behavior of navbar. Moved icons above text. Updated colors.
- `#828` Fixed z-index bug in page version tabs.
- `#853` Fixed bug where cms page creation parent page selector was not working anymore.
- `#846` Added absolute http source path for images in storage component via `getSource(true)`.
- `#845` Crawler added search data model to analys the querys and added command to send search results.
- `#839` Admin Filemanager search function to filter file list
- `#821` CMS block visibility toggler does now affect live-preview reloader
- `#817` Skip PHP 5.5 support in LUYA core.
- `#873` Added NgRest crud CSV export ability to generate a full csv based on ngrest model.
- `#866` Fixed bug when deleting a cms page template.
- `#867` Added new callbackform activefield configurations to add the ability of different input methods in Active Windows.
- `#864` Fixed issue where Active Window class properties could not be serialized as they can contain closures.
- `#861` Added new link helper to create realtive urls for the current website, use `link[//about-me]` will replace `//` with the current base url.
- `#859` Added caching abilities for storage data apis and cms nav item page content as array data recursion.
- `#858` Fixed bug where crawler word highlight functions does not quote the preg_replace identifier.
- `#856` Disable the ability to unset a current homepage in the cms module, this may lead into a state without any homepage defined.
- `#847` Fixed bug in model crud/createcreate command template where short open tag is disabled.
- `#729` Added extra variable informations when creating a block with cms-page type to help retrieve menu informations.
- `#848` Detached composition event when using language switcher composition context setter, as it causes the application language.
- `#837` Added CMS ability to preview page versions.
- `#838` Added CMS ability to preview offline pages.

1.0.0-beta6 (21.04.2016)
-------------------------

**BC BREAKS** See [UPGRADE.md](UPGRADE.md) as we have made some backward compatibility breaks in this release.

- `#805` Added CMS Keywords to CMS module in order to analyze the input content for its keywords.
- `#784` Add Blocks folder depency via `getGroup` of each block.
- `#833` Remove console CommandController and replace with runAction override of consoel application in order to make options available.
- `#826` Fixed deprecated function call in FormBlock.
- `#787` Fixed bug with sort block problem.
- `#822` zaa-checkbox-array renamed variables.
- `#818` Added basic implementation of page version in cms (run `./vendor/bin/luya commands cmsadmin updater/version` once after upgrading to beta6).
- `#815` Fixed bug where level container does also return items from other containers, add optional base element attribute for getLevelContainer
- `#810` Fixed bug where cms toolbar does not affect domain cookie storage.
- `#809` Fixed bug in SoftDelete trait and renamed SoftDeleteValue() to FieldStateDescriber().
- `#794` Added small anty spam function, added docs, added callback and nicer looking email for the contact form module.
- `#808` Images without filter are not process by imagine anymore and get copied directly.
- `#804` Fixed bug with wrong menu index generation.
- `#799` Added ability to sort filemanager columns.
- `#801` Fixed bug where multi selection of files did not work.
- `#798` Added LUYA CMS toolbar
- `#761` Added missing translations for cms block delete message.
- `#796` Fixed bug where not existing module throws an create defualt object from empty value exception.
- `#807` Rewrite of NgRest plugin system to match yii2 base object config and fix several issus with mutli lingual casted fields.
- `#802` Adding new decimal NgRest Plugin / block field type including possiblity to configure step size.
- `#758` Due to replacement of twig, cms layout files must be a phpfile instead of a twig file (see upgrade.md).
- `#754` Fixed module reflection overloading, this happens when no required get params are not in the url rules.
- `#793` Added external link parser informations like class and target blank
- `#791` Replaced the source folder with core and create a read only module as the LUYA module is no longer need since beta6.
- `#785` Added composition default behavior based on host mapping informations
- `#782` Fixed bug where CMS json response could be parsed.
- `#760` Added [bootstrap 4 module](https://github.com/luyadev/luya-bootstrap4) to enable active forms, blocks and other widgets.
- `#771` Removed LUYA module and replaced as library instead.
- `#780` Removed view path defintions
- `#774` Update to Yii Version 2.0.7
- `#779` Fixed issue where folder cache have not been reloaded when cache component is active.
- `#775` Fixed issue where migration/down could not find the migration file.
- `#776` Fixed bug where command module selector does not work with foreign modules.
- `#777` Renamed ActiveWindow folder name to lookup view files to render (Removed the suffix ActiveWindow).
- `#774` Update Yii Version to 2.0.7
- `#768` Fixed issue where language switcher widget throws an exception when rule is empty.

1.0.0-beta5 (9.2.2016)
-------------------------

- `#772` Fixing some more short open tags in kickstarter project
- `#766` Added image dimensions below the preview. Styled the dimensions div. (Image upload)
- `#743` Replacing all short open tags
- `#752` Filter import removes old filters, filter import detect chain changes and removes image sources, storage component trys to recreate an image if not existing.
- `#739` Fixed bug where menu container service does refresh and menu reloads at the same time.
- `#713` Added LIVE iFrame preview. Added styles to get something like a "window feeling".
- `#764` Fixed bug that caused the copied element to hide behind the page element.
- `#727` Added the ability to inject data into the menu component.
- `#719` Fixed bug in CMS Module, where blocks keep a empty ghost block after moving into another placeholder.
- `#762` Added class filemanager__toolbar--top to add margin-bottom to toolbar.
- `#756` Updated styles for input--vertical. Updated aws change password view.
- `#717` Updated styles for input--single-checkbox.
- `#734` Added remoteadmin module to public modules.
- `#722` Fixed bug where search results have not been sticky after update submit.
- `#711` Added information about cache and container in block wizzard.
- `#745` Fixed bug where is_hidden state of file upload has not be assigned due to model validation error.
- `#741` Added new frontendgroup module to catch permission depneding on the logged in users groups [see implentation docs](https://github.com/zephir/luya-module-frontendgroup).
- `#755` Added language switcher ability to switch between composition rules for module pages (not module blocks).
- `#757` Fixed bug where module page object returns yii\web\Response instead of string.
- `#750` Fixed bug where module block object returns yii\web\Response instead of string.
- `#747` Fixed wording bug in useronline panel of admin layout.
- `#748` Added new ngrest plugin for checkbox list arrays `checkboxList(['key' => 'value'])`.
- `#744` Added checkbox list plugin for ngrest to create checkbox element based on an array with key value pairing.
- `#735` Fixed clean deleting of cms placeholder blocks (i.e. layout block) and all attached sub blocks
- `#733` Fixed missing sub cms blocks when using copy cms block function
- `#725` Fixed missing content in layout cms blocks after page copy
- `#726` Crawler module does now ignore not text based response header.
- `#308` Added copy and paste for cms blocks
- `#716` Add is_deleted files to the storag container list.
- `#715` CMS nav item model does now slugify the alias in the model before create/update to ensure correct alias paths.
- `#721` Add a better output for duplication checks when moving cms pages.

1.0.0-beta4 (13.1.2016)
-------------------------

**BC BREAKS**

`#697`: As part of the implementation of `yii\base\Object` for ActiveWindows the process how the ActiveWindow and the ngrest works together slightly changed. Use `$config->aw->load()` instead of `$config->aw->register()`, as the ActiveWindow will be loaded directly on call. Examples of how to load the active window:

```php
load('app\modules\foobar\test\MyActiveWindow');
load([
    'class' => 'app\modules\foobar\test\MyActiveWindow',
    'property1' => 'value for property 1'
]);
```

`#690`: The new `admin\base\GenericSearchInterface` interface defines a new method `genericSearchStateProvider()` which defines the condition for the angular uirouter state to enable item clicks. There is also a method called `genericSearchHiddenFields()` which will return an array with fields not to display in admin search result list.

**ISSUES**

- `#714` Added google material-icons font to resources folder; Removed the cdn call
- `#702` Added slugify suggestion when creating a translation copy of an existing item.
- `#707` Added small padding to block-edit-content too add some space for the "help" icon.
- `#710` Added the ability to cache the menu component language containers, is on by default if any cache class is registered.
- `#703` Added highlight effect after crud item edit success.
- `#700` Added .btn--bordered class that adds a smooth black border to the btn. Improves visibility.
- `#698` Added console command controller helpers and console command `aw/create` to generate a new ActiveWindow.
- `#708` Fixed bug where ngrest list image plugin does return false and ng-src try to render the image name `false`.
- `#681` Removed js download via fxp/bower plugin and replaced by downloading resources and created vendor folder. Composer asset has been removed from luya modules.
- `#682` Added last login timestamp to user list table.
- `#685` Fixed bug where NgRest crud sort does not work anymore, changed the default output for ngrest type list calls to hide i18n date and directly return the language value from the api.
- `#692` Added date and version indicator to module creation phpdoc.
- `#697` New ActiveWindow helpers, extend from yii\base\Object to add ability to configure the classes. See BC BREAKS.
- `#706` Fixed bug where Filter::encode() trys to handler object and array values.
- `#705` Fixed bug where parse request removes partial string from the request when composition is the same as the module name begin with (`de` - `debug`).
- `#690` Added ability to click generic search items in admin search view. Therefore new methods have been implement to GenericSearchInterface.
- `#704` Added ability to close ngrest crud create, update and aw scope with ESC key.
- `#694` Pages with redirects now return the url of the redirected page instead of the temp generate alias name for this item in the menu component.
- `#695` Moved `setRelation` method tocheckbox releation plugin instead of ngrest\base\Model.
- `#696` Fixed bug where set relation method in ngrest model for checkbox realtions can handle not angular conform post data.
- `#693` Added mailer component method adresses() function to assigne multiple recipients at the same time.
- `#691` Create the module migration folder if the folder does not exists.
- `#687` Fixed issue in StorageImporter and empty storage folder.
- `#684` Improved styling of error api module mails.
- `#683` Fixed bug where nav item data update does not show loading dialog.

1.0.0-beta3 (4.1.2016)
-------------------------

**BC BREAKS**

- `#663` **Removed `admin\storage\FileQuery`, `admin\storage\ImageQuery`, `admin\storage\FolderQuery` and replace with `admin\file\Query`, `admin\image\Query`, `admin\folder\Query`.**
- `#667` **As the csrf validation is enabled by default, you have to integrate them into your forms if you are not using the ActiveForm Widget. [Guide to include CSRF Token forms](http://zero-exception.blogspot.ch/2015/01/yii2-using-csrf-token.html). Luya will auto insert the csrf meta tag to your head section if you are using the CMS Modul.**

**ISSUES**

- `#671` Auto enabled csrf meta tags registration in luya web view base class.
- `#669` fixed bug where ajax block csrf validation does not work as of get request informations.
- `#653` Added storage consistency check to import and the new storage/cleanup console command
- `#667` Enabled the csrf validation token in luya\web\Request (default setting).
- `#652` Added ability to reset/clear image and file uploads in directives.
- `#646` Added a link block with the possibility of linking to internal pages and external target.
- `#650` Updated styling; Updated old (materialize) toast calls (replaced with new ones)
- `#660` Updated spacing; Replaced arrows
- `#662` Rearrange zaa-table option icons and added auto-scroll to table
- `#654` Added border to file- and image-array, added fix break between text and button at the ImageTextBlock, added additional configuration on LinkButtonBlock and some missing translations.
- `#648` Fixed bug where ajax block callback have no composition prefix.
- `#637` Fixed issue where image upload does not change ng-model when image already exists in image data list.
- `#638` Fixed issue where menu component does not use `createRouteEnsure`.
- `#634` Added getContainer and getLevelCurrentItems for menu component.
- `#633` Added the ability to register new translations/message quickly in the Module.php via $translation property.
- `#643` Added ability to get cms menu item siblings.
- `#644` Added ability to get all menu items for a specific level `getLevelContainer` in menu component.
- `#639` Added missing translations for divider line block.
- `#158` Added ability to sort the items in list block.
- `#425` Added ability to move columns and rows up/down in table block.
- `#647` Added image delete helpers to admin storage helper.
- `#449` Added toast service with confirmations.
- `#484` Added toast service with error and success messages.
- `#649` Added maxlength for text input fields of 255 chars (on zaa-text).
- `#651` Fixed issue where image and file list array where unable to be i18n casted.
- `#659` Fixed security issue for ngrest callbacks.
- `#658` Fixed composition rules issue where parse request creates absolut urls.
- `#661` Added block helper methods (prefix with zaa) to get file/s and image/s data.
- `#663` Renamed storage query classes, added findImage, findFolder and findFile.
- `#603` Added the ability to us `no_filter` option in zaa-image-array-upload types.
- `#590` Added ability to create a new page based on another page.

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
