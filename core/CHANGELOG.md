# LUYA CORE CHANGELOG

All notable changes to this project will be documented in this file. This project make usage of the [Yii Versioning Strategy](https://github.com/yiisoft/yii2/blob/master/docs/internals/versions.md). In order to read more about upgrading and BC breaks have a look at the [UPGRADE Document](UPGRADE.md).

## 1.0.20 (in progress)

+ [#1940](https://github.com/luyadev/luya/issues/1940) Add Url helper methods `cleanHost()` and `domain()`.
+ [#1939](https://github.com/luyadev/luya/issues/1939) Added new informations to error transfer to api.
+ [#1941](https://github.com/luyadev/luya/issues/1941) Added new REST Helper method to send errors from a model or an array.

## 1.0.19 (22. July 2019)

+ [#1931](https://github.com/luyadev/luya/issues/1931) Fixed issue with relativ paths in link tag.
+ [#1927](https://github.com/luyadev/luya/issues/1927) New check whether console command is running in console application context.
+ [#1925](https://github.com/luyadev/luya/issues/1925) Add new actions and controller retrieve options in object helper.

## 1.0.18 (27. May 2019)

+ [#1921](https://github.com/luyadev/luya/issues/1921) Added new `resolveHostInfo()` in Composition component in order to find a given host for a mapping defintion.
+ Fixed issue when binary is loading config file from vendor folder.
+ Update lock files to allow latest test suite with admin 2.0 constraint.

## 1.0.17 (23. April 2019)

+ [#1799](https://github.com/luyadev/luya/issues/1799) Use relative config file path for luya binary file.
+ [#1914](https://github.com/luyadev/luya/issues/1914) Fixed problem with `RobotsFilter` when used in multiple forms on the same CMS page.
+ [#1912](https://github.com/luyadev/luya/issues/1912) Added `ObjectHelper::isTraitInstanceOf` method to check whether an object contains a certain trait or not.

## 1.0.16 (1. April 2019)

+ [#1911](https://github.com/luyadev/luya/issues/1911) Fixed bug in ArrayHelper::searchColumn() when using assoc arrays.
+ [#1910](https://github.com/luyadev/luya/issues/1910) Fixed resized callback in lazyload js when using LazyLoad widget.
+ [#1909](https://github.com/luyadev/luya/issues/1909) Fixed issued with wrong delimiter definition in StringHelper::highlightWord() function.

## 1.0.15 (19. February 2019)

+ [#1895](https://github.com/luyadev/luya/issues/1895) Changed to email output obfuscation in email tag instead of plain email mailto link.

### Added

+ [#1905](https://github.com/luyadev/luya/issues/1905) Added composition `$expectedValues` property to configure expected pattern values (test if language is in the list of valid languages).
+ [#1885](https://github.com/luyadev/luya/issues/1885) Fix issue where current url rule appends path param.
+ [#1889](https://github.com/luyadev/luya/issues/1889) Add possibility to fetch images that are inserted after lazyLoading is initialised.
+ [#1887](https://github.com/luyadev/luya/issues/1887) Add attribute hints assign option for dynamic model.

### Fixed

+ [#1907](https://github.com/luyadev/luya/issues/1907) Tags can now have escaped sub values like `file[1](file.png \(PDF\))`.
+ [#1900](https://github.com/luyadev/luya/issues/1900) Fixed issue when attachment file name is not provided.
+ [#1902](https://github.com/luyadev/luya/pull/1902) Composition component hides alternate url lang codes when hideDefaultPrefixOnly is true and current lang code is default.
+ [#1898](https://github.com/luyadev/luya/issues/1898) Telephone link raises an exception if an invalid telephone number is provided.
+ [#1888](https://github.com/luyadev/luya/issues/1888) Fixed issue with range values which can have float values.
+ [#1876](https://github.com/luyadev/luya/issues/1876) Fixed the url generation without module context when using language switcher.

## 1.0.14 (17. November 2018)

+ [#1872](https://github.com/luyadev/luya/issues/1872) Added new schemas for Json-Ld. Fixed Event Json-Ld, and TypeHinting.
+ [#1867](https://github.com/luyadev/luya/issues/1867) Rewritten lazyload js and added new placeholderSrc. Updated lazyload docs.
+ [#1870](https://github.com/luyadev/luya/issues/1870) String helper truncate middle use default truncate if no results found and added new option for case sensitive comparing.
+ [#1871](https://github.com/luyadev/luya/issues/1871) String helper highlight supports a list of words provided as array to highlight.

## 1.0.13 (30. October 2018)

+ [#1866](https://github.com/luyadev/luya/pull/1866) Make ./luya serve command work out of the box
+ [#1863](https://github.com/luyadev/luya/issues/1863) Enabled the usage of alias paths when using renderLayout() method.
+ [#1859](https://github.com/luyadev/luya/issues/1859) Fixed issue where alt body is not clean up when sending multiple messages in the same mail object.
+ [#1855](https://github.com/luyadev/luya/issues/1855) If create a url to an other module, don't replace the url with current module context.

## 1.0.12 (8. October 2018)

+ [#1856](https://github.com/luyadev/luya/issues/1856) If application console method is running, the cli determination should be forced.
+ [#1853](https://github.com/luyadev/luya/issues/1853) Add option to lazy load mocked arguments.
+ [#1852](https://github.com/luyadev/luya/pull/1852) Updated Svg widget to enable usage of symbols (svg sprite) via svg > use implementation
+ [#1851](https://github.com/luyadev/luya/issues/1851) Add string helper method highlightWord() to highlight a given word withing a string.
+ [#1850](https://github.com/luyadev/luya/issues/1850) Add string helper method truncateMiddle() to truncate a string around a given word.

## 1.0.11 (5. September 2018)

+ [#1848](https://github.com/luyadev/luya/issues/1848) Fix issue where frontend rules have precedence over admin API rules.
+ [#1840](https://github.com/luyadev/luya/issues/1840) Convert mail message into alt body automatically.
+ [#1816](https://github.com/luyadev/luya/issues/1816) View mapping to change the view folder of actions inside modules.
+ [#1844](https://github.com/luyadev/luya/pull/1844) Added translation command to add easier a new record to the translation files. This command is used in the luya-env-dev project in order to develop on the LUYA modules or create your own extensions/modules.
+ [#185](https://github.com/luyadev/luya-module-admin/issues/185) Fixed issue where applications with default route admin throw exception for assets.

## 1.0.10 (18. July 2018)

### Changed

+ [#1827](https://github.com/luyadev/luya/issues/1827) ResponseCache using PageCache filter and mark $actionsCallable and $actions as deprecated.
+ [#1821](https://github.com/luyadev/luya/issues/1821) Remove public properties from `luya\traits\CacheableTrait` in order to prevent conflicts, as they only contain fallback informations.
+ [#1820](https://github.com/luyadev/luya/issues/1820) Cover sensitive data in robots filter post data.

### Added

+ [#174](https://github.com/luyadev/luya-module-admin/issues/174) Added new option $apiRules in order to provide custom url rules for APIS.
+ [#1834](https://github.com/luyadev/luya/pull/1834) Added new option `Composer::$hideDefaultPrefixOnly`. When enabled, composition prefixes will be hidden only for default language. Takes effect only when `hidden` option is disabled.

### Fixed

+ [#1831](https://github.com/luyadev/luya/issues/1831) Fixed issue with create url and complex composition patterns.
+ [#1826](https://github.com/luyadev/luya/issues/1826) Ensure arrayable implementation for Link objects.
+ [#1830](https://github.com/luyadev/luya/issues/1830) Lazyload widget asset registration issue fixed when used in nested context.

## 1.0.9 (1. June 2018)

### Added

+ [#1814](https://github.com/luyadev/luya/issues/1814) Added new json behavior in order to encode/deocde given class attributes.
+ [#1809](https://github.com/luyadev/luya/issues/1809) Add new `autoFormat` in formatter component in order to format values based on the input type.
+ [#1815](https://github.com/luyadev/luya/pull/1815) Add new `TelephoneLink` class to support html anchor with "tel:".

### Changed

+ [#1804](https://github.com/luyadev/luya/issues/1804) Use new minify method for view compress function.
+ [#1803](https://github.com/luyadev/luya/issues/1803) Mark Encode and Timestamp as deprecated. Added JsonBehavior to encode/deocde values.

### Fixed

+ [#1251](https://github.com/luyadev/luya/issues/1251) Fix url creation for modules which are implemented on the homepage.
+ [#1802](https://github.com/luyadev/luya/issues/1802) Fix problem with export helper variable values.

## 1.0.8 (14. May 2018)

### Added

+ [#1800](https://github.com/luyadev/luya/issues/1800) Added module context for importers.

## 1.0.7 (2. May 2018)

### Addded

+ [#1795](https://github.com/luyadev/luya/issues/1795) Added JsonCruftFilter to prepend cruft string to every json response.
+ [#1791](https://github.com/luyadev/luya/issues/1791) Added minify string helper method.

## 1.0.6 (11. April 2018)

### Changed

+ [#1787](https://github.com/luyadev/luya/issues/1787) Added Secure flag and secure headers when `$ensureSecureConnection` is enabled.
+ [#1788](https://github.com/luyadev/luya/issues/1788) Remove phpmailer header (X-HEADER) information from `luya\components\Mail` component to prevent information disclosure.
+ [#1783](https://github.com/luyadev/luya/issues/1783) Remove auto setter for timezone as it is not compatible with yii timeZone propertie.

### Added

+ [#89](https://github.com/luyadev/luya-module-admin/issues/89) Strength validator to check string complexity for password validation.
+ [#1784](https://github.com/luyadev/luya/issues/1784) Added auto cover sensitive data for error api transfer.

## 1.0.5 (26. March 2018)

### Changed

+ [#1779](https://github.com/luyadev/luya/issues/1779) Refactor of luya\web\Composition component.

### Added

+ [#1781](https://github.com/luyadev/luya/issues/1781) Added application property $ensureSecureConnection to ensure secure connection when handling requests.
+ [#1762](https://github.com/luyadev/luya/issues/1762) Add luya\web\Composition::$allowedHosts to ensure the hostName from a list of valid host names. Otherwise throw forbidden exception.
+ [#1774](https://github.com/luyadev/luya/issues/1774) Provide option to configure transfer whitelist. Whitelisted exception will not transfered to the error API.

### Fixed

+ [#1778](https://github.com/luyadev/luya/issues/1778) Changed admin csrf param name in order to not terminate the frontend csrf validation process.

## 1.0.4 (28. February 2018)

### Changed

+ [#1765](https://github.com/luyadev/luya/issues/1765) Changed ObjectHelper::instanceOf to ObjectHelper::isInstanceOf in order to fix php 5.6 compatibility bug.

### Added

+ [#1760](https://github.com/luyadev/luya/issues/1760) Added Excel export to ExportHelper.

### Fixed

+ [#1730](https://github.com/luyadev/luya/issues/1730) Problem when using relativ url rule handling which are resolved trough current $app->controller.
+ [#55](https://github.com/luyadev/luya-module-admin/issues/55) Fixed issue where admin APIs can not access module context.

## 1.0.3 (24. January 2018)

### Changed

+ [#1756](https://github.com/luyadev/luya/issues/1756) Changed invalid JsonLd method calls, added new objects, value and type checks.
+ [#1754](https://github.com/luyadev/luya/issues/1754) Remove underscore when transliteration is disabled.

### Added

+ [#1759](https://github.com/luyadev/luya/issues/1759) Added luya\helpers\ObjectHelper instanceOf() method.
+ [#1755](https://github.com/luyadev/luya/issues/1755) Add json helper with isJson() method.
+ [#1757](https://github.com/luyadev/luya/issues/1757) Added new sendArrayError() method to luya\rest\Controller. Moved helper classes into RestBehvaiorsTrait as they can be used in both situations.

## 1.0.2 (17. January 2018)

### Changed

+ [#1739](https://github.com/luyadev/luya/issues/1739) Removed deprecated getLuyaVersion() method in luya\console\Command class.
+ [#1753](https://github.com/luyadev/luya/issues/1753) Removed version info from generated files trough commands.

### Fixed

+ [#1749](https://github.com/luyadev/luya/pull/1749) Ensure bin file app can find autoloader when running from an outside folder.
+ [#1747](https://github.com/luyadev/luya/pull/1747) Allow to override translations files trough application config.

## 1.0.1 (3. January 2018)

### Changed

+ [#1739](https://github.com/luyadev/luya/issues/1739) Mark getLuyaVersion() as deprecated in luya\console\Command.

### Added

+ [#1744](https://github.com/luyadev/luya/issues/1744) New getter and setter method for urlRules, provides backwards compatibility trough none virtual property access.
+ [#1735](https://github.com/luyadev/luya/pull/1735) JsonLd: CreativeWork, Article, SocialMediaPosting, BlogPosting, LiveBlogPosting
+ [#1737](https://github.com/luyadev/luya/issues/1737) Added luyadev command to clone and update repos. This command is used in the luya-env-dev project in order to develope on the LUYA modules or create your own extensions/modules.
+ [#1738](https://github.com/luyadev/luya/issues/1738) Update module create readme with useAppViewPath information.

### Fixed

+ [#1745](https://github.com/luyadev/luya/issues/1745) Provide controller files fallback for LUYA core modules.
+ [#1731](https://github.com/luyadev/luya/issues/1731) JsonLd Thing definition must be from type Thing.

## 1.0.0 (12. December 2017)

### Changed

+ [#1572](https://github.com/luyadev/luya/issues/1572) CMS blocks are now deliverd trough [generic](https://github.com/luyadev/luya-generic) and [bootstrap3](https://github.com/luyadev/luya-bootstrap3) repos, therefore run the updater `./luya cms/updater/generic`.
+ [#1559](https://github.com/luyadev/luya/issues/1569) Renamed luya\admin\image\Item::getSource() to getHttpSource() this will affect also the getter properties.
+ [#1564](https://github.com/luyadev/luya/issues/1564) Refactoring of gallery module, removed old unused methods, switch to ActiveQuery relation usage.
+ [#1522](https://github.com/luyadev/luya/issues/1522) Text and Textarea NgRest plugins auto encode input data after find.
+ [#1505](https://github.com/luyadev/luya/issues/1505) Minor API Breaks and removed deprecated methods.
+ [#1341](https://github.com/luyadev/luya/issues/1341) Changed signature of `changePassword($newPassword)` in `luya\admin\aws\ChangePasswordInterface`.
+ [#1574](https://github.com/luyadev/luya/issues/1574) Changed Active Window $alias property to $label. Use defaultLabel() in order to set a default label.
+ [#1567](https://github.com/luyadev/luya/issues/1567) Discontinue development of Exporter Module.
+ [#1568](https://github.com/luyadev/luya/issues/1568) Add file system layer for Storage component.
+ [#1505](https://github.com/luyadev/luya/issues/1505) Renamed property of luya\cms\frontend\Module from `$enableCompression` to `$contentCompression`.

### Added

+ [#1679](https://github.com/luyadev/luya/issues/1679) Updated styles to support up to 3 icons in the treeview item context.
+ [#1557](https://github.com/luyadev/luya/issues/1557) Support non transliterated CMS URLs by providing the new `Inflection` class. This will enable non-latin URLs.
+ [#1700](https://github.com/luyadev/luya/issues/1700) Redirection mappings in CMS Module.
+ [#1682](https://github.com/luyadev/luya/issues/1682) NgRest relations can now handle auto set the primary model value, auto open the tab and define a tab label from the crud list.
+ [#1695](https://github.com/luyadev/luya/issues/1695) NgRest Crud can handle composite primary keys.
+ [#1639](https://github.com/luyadev/luya/issues/1639) Application wide configuration table which can be managed in the admin.
+ [#1467](https://github.com/luyadev/luya/issues/1467) Main nav context menu for logout and account preferences.
+ [#1557](https://github.com/luyadev/luya/issues/1557) Allow unicode chars for cms page aliases and slugify directives.
+ [#1551](https://github.com/luyadev/luya/issues/1551) JsonLd basic implementation.
+ [#1534](https://github.com/luyadev/luya/issues/1534) Link ability for files and e-mail addresses.
+ [#1540](https://github.com/luyadev/luya/issues/1540) CMS Log Dashboard.
+ [#1304](https://github.com/luyadev/luya/issues/1304) Crud indicates the total amount of rows with pagination enabled or disabled.
+ [#1521](https://github.com/luyadev/luya/issues/1521) Bind session token to current IP in order to prevent session hijacking.
+ [#1511](https://github.com/luyadev/luya/issues/1511) Added page id information in cms menu tree on hover (alt,title).
+ [#1307](https://github.com/luyadev/luya/pull/1307) Block wizzard creates admin view according to given configs and vars.
+ [#1493](https://github.com/luyadev/luya/issues/1493) Show ability to search in relations when using large data tables.
+ [#1439](https://github.com/luyadev/luya/issues/1439) Added icons to admin responsive menu.
+ [#1494](https://github.com/luyadev/luya/issues/1494) CMS page selection hides container element by default, fixed arrow keys.
+ [#1461](https://github.com/luyadev/luya/issues/1461) Admin search panel auto focus input field and search groups can be toggled.
+ [#1462](https://github.com/luyadev/luya/issues/1462) CMS block holder toggler in order to optimize view for small screens.
+ [#1515](https://github.com/luyadev/luya/issues/1515) Change access token on logout provides a shorter periode of being violated.

### Fixed

+ [#1652](https://github.com/luyadev/luya/issues/1652) Missing modal-open class issue with multiple nested modals problem fixed.
+ [#1578](https://github.com/luyadev/luya/issues/1578) Fixed tons of typo and spelling issues in the LUYA guide
+ [#1644](https://github.com/luyadev/luya/issues/1644) Added element null check to cms toolbar.js
+ [#1556](https://github.com/luyadev/luya/issues/1556) Updated arrow position; Removed wrong & unecessary <th> in filemanager (fixes position and table display in modal)
+ [#1520](https://github.com/luyadev/luya/issues/1520) Selects with initvalue can no longer reset to null values.
+ [#1562](https://github.com/luyadev/luya/issues/1562) Hide CMS Page settings overlay after save.
+ [#1629](https://github.com/luyadev/luya/issues/1629) Fixed bug when moving blocks from placeholder block into parent placeholder.
+ [#1654](https://github.com/luyadev/luya/issues/1654) Updated styling for treeview empty placheolder message and added styling for drag hover.
+ [#1640](https://github.com/luyadev/luya/issues/1640) Use container name for page overview instead of alias.
+ [#1598](https://github.com/luyadev/luya/issues/1598) Hide block delete button when insufficient permissions, disable draging and editing if there is no update permissions.
+ [#1563](https://github.com/luyadev/luya/issues/1563) Adjust position of first sortable arrow as desired.
+ [#1545](https://github.com/luyadev/luya/issues/1545) Adjust position of page version dropdown content on admin edit section.
+ [#1549](https://github.com/luyadev/luya/issues/1549) Hide version informations for other page types then page content.
+ [#1550](https://github.com/luyadev/luya/issues/1550) Readded option to change the page type in CMS Module.
+ [#1480](https://github.com/luyadev/luya/issues/1480) Dropdown select overlay z-index fixed by closing all other selects.
+ [#1519](https://github.com/luyadev/luya/issues/1519) Multiple inputs problem with empty item rows convert to object instead of array.
+ [#1535](https://github.com/luyadev/luya/issues/1535) Date and Datetime reset model buttons.
+ [#1536](https://github.com/luyadev/luya/issues/1536) Link directive display wrong reset data button if empty object exists.
+ [#1533](https://github.com/luyadev/luya/issues/1533) Draft mode does not display first created version. Hide elements when page is draft.
+ [#1526](https://github.com/luyadev/luya/issues/1526) Changed has-enough-space directive to use direct parent of element to check if there is enough space.
+ [#1509](https://github.com/luyadev/luya/issues/1509) Added a table-responsive-wrapper div to all responsive tables. This improves CRUD behaviour on mobile.
+ [#1479](https://github.com/luyadev/luya/issues/1479) Block group translation names where not displayed correctly. Old block groups where not deleted anymore.
+ [#1470](https://github.com/luyadev/luya/issues/1470) Action columns in crud visibility fixed by button group overlay on hover.
+ [#1527](https://github.com/luyadev/luya/issues/1527) CMS Table block convert newlines to br when markdown is disabled.
+ [#1512](https://github.com/luyadev/luya/issues/1512) Drag and Drop does not work in Firefox Browsers.
+ [#1517](https://github.com/luyadev/luya/issues/1517) Fixed issue where FileHelper::classInfo does not determine namespace correctly on windows.
+ [#1401](https://github.com/luyadev/luya/issues/1401) Multiple inputs key indexing problem fixed.
+ [#1474](https://github.com/luyadev/luya/issues/1474) Fixed problem where modal in modal does not apply `modal-body` class correctly.
+ [#1473](https://github.com/luyadev/luya/issues/1473) Fixed issue where user default language is not provided when user has no settings stored.
+ [#1491](https://github.com/luyadev/luya/issues/1491) Updated timeline styles to prevent line from overlapping first and last entry
+ [#1490](https://github.com/luyadev/luya/issues/1490) Updated tab styling to support nested tab contents (tab-content, tab-pane)
+ [#1489](https://github.com/luyadev/luya/issues/1489) Changed default checkbox styles and updated checkbox html in all files
+ [#1455](https://github.com/luyadev/luya/issues/1455) Re-Implemented the group function for crud; Updated card styles to support toggle icon
+ [#1504](https://github.com/luyadev/luya/issues/1504) Added is-empty class to zaa-list directives and updated flag positions based on this class.
+ [#1503](https://github.com/luyadev/luya/issues/1503) Deleted news are now hidden in getAvailableNews() method.
+ [#1486](https://github.com/luyadev/luya/issues/1486) Toast messages displayed correctly with multiple lines.
+ [#1492](https://github.com/luyadev/luya/issues/1492) Fixed bug where CRUD pagination does not work anymore.
+ [#1464](https://github.com/luyadev/luya/issues/1464) Adjusted icon positions for dropdown list selection
+ [#1460](https://github.com/luyadev/luya/issues/1460) Fixed issue with login autofill and floating labels
+ [#1471](https://github.com/luyadev/luya/issues/1471) Added word-break: break-all to block-front; Could lead to other problems but couldn't see any so far
+ [#1478](https://github.com/luyadev/luya/issues/1476) Cursor pointer and user-select none on [ng-click] elements
+ [#1478](https://github.com/luyadev/luya/issues/1478) Updated toast positioning if mainnav is expanded
+ [#1477](https://github.com/luyadev/luya/issues/1477) Fixed z-index issue with luya search bar
+ [#1475](https://github.com/luyadev/luya/issues/1475) Fixed bug in cms menu tree when moving an element after an existing element.
+ [#1469](https://github.com/luyadev/luya/issues/1469) Fixed bug where short open tags are required by default.
+ [#1468](https://github.com/luyadev/luya/issues/1468) Fixed bug where on windows platforms the alias for the luyadev installer vendor file not be retrieved.
+ [#1456](https://github.com/luyadev/luya/issues/1456) Fixed bug where login forms make problems on Firefox Browsers.
+ [#1458](https://github.com/luyadev/luya/issues/1458) Fixed bug where crud search does not apply the model changes.
+ [#1454](https://github.com/luyadev/luya/issues/1454) Fixed Problem with Admin UI and Firefox Browsers.
+ [#1371](https://github.com/luyadev/luya/issues/1371) Fixed issue where cms page last update does not refresh the user id.


1.0.0-RC4 (5. September 2017)
-------------------

### Changed

+ [#1408](https://github.com/luyadev/luya/issues/1408) CMS Module removed bootstrap process inside module, use Bootstrap class instead.
+ [#1414](https://github.com/luyadev/luya/issues/1414) Renamed Angular Helper methods, removed all the zaa prefixes.
+ [#1308](https://github.com/luyadev/luya/issues/1308) Renamed `luya\admin\ngrest\plugins\CheckboxRelation::labelFields` to `luya\admin\ngrest\plugins\CheckboxRelation::labelField`
+ [#1301](https://github.com/luyadev/luya/issues/1301) Move the CRUD commands to the admin module `admin/crud/create` and `admin/crud/model`.
+ [#1289](https://github.com/luyadev/luya/issues/1289) Remove `luyaLanguage` application property and replace with admin module `interfaceLanguage` property.
+ [#1294](https://github.com/luyadev/luya/issues/1294) Moved Active Window scaffolding command into admin Module `admin/aw/create`
+ [#1277](https://github.com/luyadev/luya/issues/1277) Renamed `getPlacholderValue()` to `getPlaceholderValue()`.
+ [#1273](https://github.com/luyadev/luya/issues/1273) Mail component remove `adresses()` replace with `addresses()`.
+ [#1264](https://github.com/luyadev/luya/issues/1264) Renamed `$LinkActiveClass` property to `$linkActiveClass` in luya\cms\widgets\LangSwitcher.
+ [#1295](https://github.com/luyadev/luya/issues/1295) Fully removed all Twig files, tests and components as announced.
+ [#1448](https://github.com/luyadev/luya/issues/1448) Admin translations must be registered in Module::onLoad.

### Added

+ [#1292](https://github.com/luyadev/luya/issues/1292) NEW ADMIN UI!
+ [#1361](https://github.com/luyadev/luya/issues/1361) Added ability to provide json file for cms layouts in order to render the grid in the admin according to the frontend.
+ [#1293](https://github.com/luyadev/luya/issues/1293) Dashboard objects can be used by admin modules.
+ [#1351](https://github.com/luyadev/luya/issues/1351) Frontend Storage Upload validator which stores images and files in admin storage component.
+ [#1375](https://github.com/luyadev/luya/issues/1375) Added Import Helper class which provides functions to parse CSV files to Arrays.
+ [#1332](https://github.com/luyadev/luya/issues/1332) Added Export Helper class in order to generate CSV Files from Arrays.
+ [#1312](https://github.com/luyadev/luya/issues/1312) ArrayHelper::generateRange for select dropdowns with numeric values.
+ [#1303](https://github.com/luyadev/luya/issues/1303) NgRest SelectModel valueField is automatically retrieved from the model class if no value is provided.
+ [#1291](https://github.com/luyadev/luya/issues/1291) Replace User Sidebar with User Dashboard to change Password.
+ [#1288](https://github.com/luyadev/luya/issues/1288) Added Color-Wheel NgRest Plugin and Angular Type.
+ [#1287](https://github.com/luyadev/luya/issues/1287) Sortable Plugin and Trait added.
+ [#1270](https://github.com/luyadev/luya/issues/1270) Module block set resolved query params into the request component if not strict mode.
+ [#1268](https://github.com/luyadev/luya/issues/1268) Module block strict render ability in order to strict render the given action and controller paths instead of parse them trough the request component.
+ [#1227](https://github.com/luyadev/luya/issues/1227) Added preloadModels() method for the Menu Query in order to collect all models for the given request. This can strongly reduce the sql count when working with properties or models.
+ [#1266](https://github.com/luyadev/luya/issues/1266) render() method for the mailer component in order to provide controller template files.
+ [#1269](https://github.com/luyadev/luya/issues/1269) Add raw option for html block in order to render the html output in admin view.
+ [#1215](https://github.com/luyadev/luya/issues/1215) Added type float and double in ngrest data types to use decimal.
+ [#1119](https://github.com/luyadev/luya/issues/1119) Added PostgreSQL Compatibility.
+ [#1331](https://github.com/luyadev/luya/issues/1331) Active Window generator generates index action view file.

### Fixed

+ [#1346](https://github.com/luyadev/luya/issues/1346) Fixed bug with ngrest scope delete defintions.
+ [#1355](https://github.com/luyadev/luya/issues/1355) Module migrations uses templates based on input data.
+ [#1248](https://github.com/luyadev/luya/issues/1248) Fixed caption of "block groups" does not obey the user's language option.
+ [#1272](https://github.com/luyadev/luya/issues/1272) Empty layout block reloading problem has been fixed due to rewrite of the cms controllers which reloads the placeholders.
+ [#1356](https://github.com/luyadev/luya/issues/1356) Fixed problem with when ngrest plugin SelectModel target class is the same model.
+ [#1369](https://github.com/luyadev/luya/issues/1369) Flow Uploader lost bearer token while uploading images.
+ [#1290](https://github.com/luyadev/luya/issues/1290) Fixed Tooltip Bug, cause of lexer parser error. Wrong directive variable scope declaration.
+ [#1286](https://github.com/luyadev/luya/issues/1286) Filemanager show error message on error.
+ [#1267](https://github.com/luyadev/luya/issues/1267) Fixed bug where module block action params overrides the default values, merge instead.
+ [#1265](https://github.com/luyadev/luya/issues/1265) Using https for Google Maps embed code.

1.0.0-RC3 (11. April 2017)
-------------------

### Changed

+ [#1229](https://github.com/luyadev/luya/issues/1229) The ngRest CheckboxRelation plugin dropped the support for ActiveRecord object getters inside the labelTemplates, use the closure function inside the labelFields propertie instead.
+ [#1208](https://github.com/luyadev/luya/issues/1208) Renamed `luya\cms\widgets\LanguageSwitcher` to `LangSwitcher` and removed the template usage as it should not be part of the widget.
+ [#1180](https://github.com/luyadev/luya/issues/1180) Replaced `luya\admin\ngrest\base\ActiveWindowView::callbackButton()` by widget `luya\admin\ngrest\aw\CallbackButtonWidget::widget()`.
+ [#1177](https://github.com/luyadev/luya/issues/1177) The luya\web\Elements component looks for the elements.php inside the @app/views folder instead of @app.
+ [#1114](https://github.com/luyadev/luya/issues/1114) Updated materializecss to newest version and removed unused files.
+ [#1127](https://github.com/luyadev/luya/issues/1127) Deprecated, renamed or removed functions collection.
+ [#1126](https://github.com/luyadev/luya/issues/1126) Moved CLI commands to the related modules.
+ [#1102](https://github.com/luyadev/luya/issues/1102) Removed News Module Tag table and replace by admin modules Tag models.
+ [#1098](https://github.com/luyadev/luya/issues/1098) Changed luya\base\Widget view path behavior to default implementation with option to enable app view paths lookup.
+ [#1109](https://github.com/luyadev/luya/issues/1109) In order to prevent blocks to extend from cms blocks, flag all cms blocks as final.
+ [#1076](https://github.com/luyadev/luya/issues/1076) Twig Component triggers now an deprecated notice message.
+ [#1218](https://github.com/luyadev/luya/issues/1218) Renamed InfoActiveWindow to DetailViewActiveWindow.
+ [#1244](https://github.com/luyadev/luya/issues/1244) Crawler DefaultController returns ActiveDataProvider instead of ActiveRecord results.
+ [#1231](https://github.com/luyadev/luya/issues/1231) Upgrade to Angular 1.6 therfore all custom angular admin js files have to make sure to be compatible with Version 1.6 (dropped .success and .error for $http component)

### Added

+ [#1163](https://github.com/luyadev/luya/issues/1163) Styling of the toggler. Added toggles for each container.
+ [#1245](https://github.com/luyadev/luya/issues/1245) Added gulp workflow to cms/admin.
+ [#1245](https://github.com/luyadev/luya/issues/1245) Added gulp workflow to cms/admin.
+ [#724](https://github.com/luyadev/luya/issues/724) Removed compass configs in admin module and added gulp workflow.
+ [#1243](https://github.com/luyadev/luya/issues/1243#issuecomment-288064499) Enabled all flags
+ [#1228](https://github.com/luyadev/luya/issues/1228) Remove session serailizer for ngRestConfig.
+ [#1230](https://github.com/luyadev/luya/issues/1230) New ngRestScopes() resolves the need for ngRestConfig($config) method.
+ [#1214](https://github.com/luyadev/luya/issues/1214) Added JSON-LD class to add rich snippet informations to a website.
+ [#1124](https://github.com/luyadev/luya/issues/1124) Refactor all CMS blocks with UnitTests and PhpBlocks.
+ [#1211](https://github.com/luyadev/luya/issues/1211) Add new link directive with ability to deselect a link.
+ [#903](https://github.com/luyadev/luya/issues/903) Added file manager details.
+ [#1216](https://github.com/luyadev/luya/issues/1216) Storage Item object integrated Arrayble Interface.
+ [#1224](https://github.com/luyadev/luya/issues/1224) Settings to define a 404 Error Page to render on HttpExceptions
+ [#1226](https://github.com/luyadev/luya/issues/1226) Delete language item in cms.
+ [#1225](https://github.com/luyadev/luya/issues/1225) Formatter component extends default formats for languages.
+ [#1222](https://github.com/luyadev/luya/issues/1222) Extend from BaseYii file in order to provide IDE Auto Complet.
+ [#1221](https://github.com/luyadev/luya/issues/1221) Added CMS Query `in` expression for where conditions.
+ [#1220](https://github.com/luyadev/luya/issues/1220) Menu Item object added new $seoTitle (getSeoTitle()) function in order to return the alternative SEO title definition.
+ [#1214](https://github.com/luyadev/luya/issues/1214) Adding JsonLd class in order to register Schema Microdata informations to the View.
+ [#1188](https://github.com/luyadev/luya/issues/1188) Change the layout file for cms page.
+ [#1202](https://github.com/luyadev/luya/issues/1202) Added Arrayable implementation for ExternalLink and menu\Item.
+ [#1200](https://github.com/luyadev/luya/issues/1200) Added new block type `zaa-multiple-inputs` to create more flexible blocks
+ [#1193](https://github.com/luyadev/luya/issues/1193) Slugify Plugin to generate aliases with only lower case letters, numbers and strikes.
+ [#1187](https://github.com/luyadev/luya/issues/1187) ActiveQueryCheckboxInjector has new `label` attribute in order to define the rendering for the dropdown label in the block admin.
+ [#1171](https://github.com/luyadev/luya/issues/1171) CMS Menu item has method `getAbsoluteLink()` in order to retrieve link with prepand host scheme.
+ [#1137](https://github.com/luyadev/luya/issues/1137) Created `fixed-table-head` directive and added it to CRUD and filemanager
+ [#1169](https://github.com/luyadev/luya/issues/1169) Callable function for labelFields in the CheckboxRelation Plugin.
+ [#1118](https://github.com/luyadev/luya/issues/1118) Variation/Flavors for blocks can be configure in the config file in order to override and hide fields.
+ [#1117](https://github.com/luyadev/luya/issues/1117) Content Proxy allows you to sync files and data from one environment into another.
+ [#1140](https://github.com/luyadev/luya/issues/1140) Added new block getIsDirtyDialogEnabled() method in order to disable the dirty dialog when blocks do not require any configuration.
+ [#1116](https://github.com/luyadev/luya/issues/1116) Injectors can be appended to the end of the configuration list.
+ [#1135](https://github.com/luyadev/luya/issues/1135) Command to generate only the ngrest model `crud/model "path/to/Model"`.
+ [#1136](https://github.com/luyadev/luya/issues/1136) Block generate uses the luya\admin\base\TypesInterface.
+ [#1134](https://github.com/luyadev/luya/issues/1134) ToggleStatus plugin ables to toggle the status from the crud list overview.
+ [#1133](https://github.com/luyadev/luya/issues/1133) Added callable $labelField and getter access for ngrest plugin luya\admin\ngrest\plugins\SelectModel.
+ [#1120](https://github.com/luyadev/luya/issues/1120) Add Hook mechanism in order to trigger contents.
+ [#1115](https://github.com/luyadev/luya/issues/1115) ActiveDataProvider default sorting configuration for news article overview.
+ [#1018](https://github.com/luyadev/luya/issues/1018) NgRest SelectModel Plugins where conditions, labelFields and labelTemplate properties added.
+ [#1010](https://github.com/luyadev/luya/issues/1010) Ability to soft delete admin languages if its not the system default language.
+ [#1110](https://github.com/luyadev/luya/issues/1110) Filemanager is sorting the directories alphabetically instead of chronologically.
+ [#1100](https://github.com/luyadev/luya/issues/1100) NgRestModel scenarios implements the restupdate and restcreate scenarios by default now.
+ [#1108](https://github.com/luyadev/luya/issues/1108) Added schema builder ability for migration files in order to support other shemes like postgreSQL.
+ [#1106](https://github.com/luyadev/luya/issues/1106) Added possibility to mock element arguments for the styleguide.
+ [#1096](https://github.com/luyadev/luya/issues/1096) News Module added teaser_text field in article model.
+ [#1006](https://github.com/luyadev/luya/issues/1006) Added spanish translations to all luya core modules and administration interface.
+ [#1103](https://github.com/luyadev/luya/issues/1103) InfoActiveWindow make usage of the yii\widgets\DetailView in order to configure attributes.
+ [#626](https://github.com/luyadev/luya/issues/626) User location for CMS and CRUD locations, page or crud item will be locked afterwards.
+ [#1158](https://github.com/luyadev/luya/issues/1158) Greek translations added.
+ [#1121](https://github.com/luyadev/luya/issues/1121) Ukrain translations added.
+ [#1154](https://github.com/luyadev/luya/issues/1154) Italian translations added.
+ [#1205](https://github.com/luyadev/luya/issues/1205) Vietnamese translations added.
+ [#1236](https://github.com/luyadev/luya/pull/1236) Portuguese translations added.

### Fixed

+ [#1255](https://github.com/luyadev/luya/issues/1255) Fixed scroll bug and improved over all behavior.
+ [#1254](https://github.com/luyadev/luya/issues/1254) Updated CRUD pagination styles.
+ [#1138](https://github.com/luyadev/luya/issues/1138) Updated responsive menu bar styles to improve the user experience on smaller screens.
+ [#1186](https://github.com/luyadev/luya/issues/1186) Image records not deleted from list without cache reload.
+ [#1162](https://github.com/luyadev/luya/issues/1162) Unable to create pages from empty draft selection.
+ [#1143](https://github.com/luyadev/luya/issues/1143) Fixed image directive filter preselection, due to an angular convert to number problem.
+ [#1156](https://github.com/luyadev/luya/issues/1156) Fixed issue where crawler preview does not decode html entities.
+ [#1146](https://github.com/luyadev/luya/issues/1146) Fixed url rule behavior when composition is hidden but an url rule is a composition rule.
+ [#1147](https://github.com/luyadev/luya/issues/1147) Empty file caption names contains the original file name.
+ [#1130](https://github.com/luyadev/luya/issues/1130) Fixed issue which prevents item redirection loops.
+ [#1101](https://github.com/luyadev/luya/issues/1101) Rest model validation did not use proper language for the yii translations based on the user language.
+ [#1111](https://github.com/luyadev/luya/issues/1111) Storage File selection does not display file name cause of not strict comparing method.
+ [#1099](https://github.com/luyadev/luya/issues/1099) Broken file list block translations fixed.
+ [#1097](https://github.com/luyadev/luya/issues/1097) Removed unused codes from the UrlManager parseRequest() method.

1.0.0-RC2 (29. Nov 2016)
-----------------------

### Changed

+ [#1070](https://github.com/luyadev/luya/issues/1070) **[BC BREAK]** Renamed methods of the block interface. Change `getBlockGroup()` to `blockGroup()`.
+ [#1058](https://github.com/luyadev/luya/issues/1058) **[BC BREAK]** Removed all massive assigned vars, cfgs, extras and placeholders from the PHP Block view.
+ [#1069](https://github.com/luyadev/luya/issues/1069) **[BC BREAK]** Removed CMS Block assets propertie in order to reduce RAM usage and follow Yii guidelines in order to register assets.
+ [#1068](https://github.com/luyadev/luya/issues/1068) **[BC BREAK]** Cms Block zaa() helper methods moved to \luya\cms\helpers\BlockHelper and marked methods as deprecated.
+ [#1067](https://github.com/luyadev/luya/issues/1067) **[BC BREAK]** Admin Module Menu: itemApi() routes are now separeted by slashes instead of dashes. As this supports native Yii handling.
+ [#1045](https://github.com/luyadev/luya/issues/1045) **[BC BREAK]** Admin modules `getMenu()` method must return an `luya\admin\components\AdminMenuBuilder` object instead of an array. A deprecated message is triggered when using the old menu builder functions.
+ [#1075](https://github.com/luyadev/luya/issues/1075) **[BC BREAK]** Frontend and Admin Controller and Module assets can not be stored in the `$assets` property of a module or controller any more.
+ [#1086](https://github.com/luyadev/luya/issues/1086) Mark $page component as deprecated as properties can be accessed trough the menu component.
+ [#1066](https://github.com/luyadev/luya/issues/1066) NgRestModel methods renamed: `ngrestExtraAttributeTypes` to `ngRestExtraAttributeTypes` and `ngrestAttributeTypes` to `ngRestAttributeTypes`.
+ [#1043](https://github.com/luyadev/luya/issues/1043) Upgrade to 2.0.10 version of the Yii Framework.

### Added

+ [#1081](https://github.com/luyadev/luya/issues/1081) Generate Link Interface for internal and external links in order to identify different link types.
+ [#1082](https://github.com/luyadev/luya/issues/1082) Link plugin for ngRest configuration in order to provide internal or external links.
+ [#1003](https://github.com/luyadev/luya/issues/1003) The crawler tag CRAWL_TITLE has been added to ensure a customization of the titles.
+ [#1008](https://github.com/luyadev/luya/issues/1008) Administration interface language can be changed and stored in the user settings.
+ [#1014](https://github.com/luyadev/luya/issues/1014) NgRest Crud has a new possibility to work with relation data via the `ngRestRelations()` method inside the NgRestModel. This allows you to open relation data in new tabs.
+ [#1038](https://github.com/luyadev/luya/issues/1038) Method `createCallbackUrl($callback)` added for ActiveWindows in order to get the absolut url for a callback, this is usefull when creating callbacks which can return a pdf for example.
+ [#1007](https://github.com/luyadev/luya/issues/1007) French translations available for all core modules.
+ [#1046](https://github.com/luyadev/luya/issues/1046) Hide menu items in the administration in order to enable crud relations with permissions but hide the menu point of the ngrest crud inside the admin interface.
+ [#1037](https://github.com/luyadev/luya/issues/1037) Image property abstract class to allow short and faster implementation of image properties.
+ [#1004](https://github.com/luyadev/luya/issues/1004) CMS Page field to set a custom page title tag in order to add SEO optimized titles.
+ [#1048](https://github.com/luyadev/luya/issues/1048) Crawler stores meta description infos into a seperat field in order to display description in search results.
+ [#1047](https://github.com/luyadev/luya/issues/1047) Title, Keyword and Description are now part of the Crawlers contnet, as the content is where the search field is look for the search query.
+ [#1049](https://github.com/luyadev/luya/issues/1049) Admin Filemanager supports replacement of files therefore the angular file upload component has been updated.
+ [#1051](https://github.com/luyadev/luya/issues/1051) Added new Meida block group, changed default positioning for standard groups, make block creator usage of Project block group by default.
+ [#1057](https://github.com/luyadev/luya/issues/1057) PHP Block CMS View class provides more and better helper methods in order to retrieve config contents.
+ [#1060](https://github.com/luyadev/luya/issues/1060) Filemanager Drag&Drop and Copy&Paste of files enabled (Chrome, Firefox and HTML5 Browsers only).
+ [#1063](https://github.com/luyadev/luya/issues/1063) Cleanup the block interface in order to make concret block implementations.
+ [#1059](https://github.com/luyadev/luya/issues/1059) Block Generator also generates the view file of the PHPBlock in the depending view folder.
+ [#1000](https://github.com/luyadev/luya/issues/1000) The CRUD generator will store the model in the shared models folder if available.
+ [#999](https://github.com/luyadev/luya/issues/999) Rewritten the CRUD generator and added ability to disable i18n fiel generation.
+ [#991](https://github.com/luyadev/luya/issues/991) User settings stores CRUD orderBy state in database for each ngrest crud setup.
+ [#919](https://github.com/luyadev/luya/issues/919) Added new option for image, imageArray, file and fileArray ngrest plugins in order to return an iterator or item object instead of database values.

### Fixed

+ [#1072](https://github.com/luyadev/luya/issues/1072) Admin services will not force reload on each click when array is empty.
+ [#1078](https://github.com/luyadev/luya/issues/1078) Fixed bug where cms block press enter does not save values but closes block form visbility.
+ [#1002](https://github.com/luyadev/luya/issues/1002) Override the core commands method in the console application in order the provide the ability to use controllerMap variable for configurations in the applcation.
+ [#1011](https://github.com/luyadev/luya/issues/1011) The ViewContext implementation for cmslayout rendering allows you now to render other templates inside a cmslayout.
+ [#1044](https://github.com/luyadev/luya/issues/1044) Changing the cms permission force menu reload in order to fix bug with old menu permissions.
+ [#1013](https://github.com/luyadev/luya/issues/1013) Delete a cms page displays blank page and reloads menu, fixed bug where page was still visible.
+ [#1061](https://github.com/luyadev/luya/issues/1061) CMS Page properties with overriden default implementation returns wrong administration api value.
+ [#1062](https://github.com/luyadev/luya/issues/1062) CMS Layout files will ignore prefixed files with . and _ and folders inside the cmslayout folder.
+ [#987](https://github.com/luyadev/luya/issues/987) Fixed issue with image auto rotate and moved to imagine extension version ~2.1.0

1.0.0-RC1 (04.10.2016)
-----------------------

+ [#806](https://github.com/luyadev/luya/issues/806#issuecomment-248597369) **[BC BREAK]** Renamed to `configs/server.php` to `configs/env.php`, new projects will also have the env prefix for the config names.
- `#976` **[BC BREAK]** Remove $isCoreModule replace with CoreModuleInterface
+ [#972](https://github.com/luyadev/luya/issues/972) **[BC BREAK]** Merged to cms and cmsadmin modules into one folder and changed the namespace to `luya\cms` instead of `cms`/`cmsadmin`.
- `#973` **[BC BREAK]** Removed `$assets` property from **none admin modules**.
- `#974` **[BC BREAK]** Removed `$isAdmin` property.
- `#970` **[BC BREAK]** Deleted, renamed and rearranged LUYA core REST classes and methods.
- `#995` Added Grouping/Section ability to for the crawler.
- `#830` Added Textarea auto height plugin
- `#983` Added LazyLoad Widget to the LUYA core features.
- `#979` Added option to enable markdown parsing for table blocks.
- `#971` Added basic pagination for NgRest Apis.
- `#956` Added optional image css class and layout css class in block configurations.
- `#959` Added block injectors to simplify relations, links and other helpfull tools to make less complex blocks.
- `#998` Added the gii model generator to build the model rules() for the crud generator command crud/create.
- `#994` Added ability to copy an existing page with all its languages and blocks.
- `#965` Fixed bug where cms pages are lost while creating when selecting a container but choose a sub page not from the related container.
- `#957` Fixed bug where cms admin container movement lost container_id reference of children elements.
- `#963` Fixed bug where caching if block is not reseted correctly.
- `#836` Fixed bug where storage importer removes all files.
- `#958` Fixed bug where date pickers does not work in block context but in crud context.
- `#962` Fixed bug where abstract class should not implement static public function in php versions 5.2.0 - 5.6.25.
- `#958` Fixed bug where datapicke does not reset correctly or wrong insereted dates crash the date/datetime fields.
- `#836` Fixed bug where importer does delete wrong files.
- `#989` Fixed bug where redirect and module pages are lost when choosing a container but also choose a subsite from another container.
- `#709` Removed ApiCmsNavItemPageBlockItem factory and angular resources dependencie.
