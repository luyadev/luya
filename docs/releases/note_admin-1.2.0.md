LUYA Admin module release 1.2 and CMS module release 1.0.4

## Admin Security Improvements

Security is a top priority for any web framework and web application, therefore it was also a very important aspect in the development of LUYA from day one. The Yii framework provides a good foundation with its [security features](https://www.yiiframework.com/doc/guide/2.0/en/security-overview), but every line of code built on top of it has to be as bulletproof as its foundation. When there was an opportunity to have LUYA tested with a security audit executed by a Swiss security company, we gladly took the chance. This resulted in a list of security improvements included in this update:

+ Unparsable JSON Cruft: all JSON responses are now prepended with an unparsable cruft `)]}',` in order to prevent ["JSON hijacking"](https://portswigger.net/blog/json-hijacking-for-the-modern-web).
+ The Angular source code is now uglified and minified. Therefore Angular strict-di mode is enabled by default.
+ If a user changes the account's email in the admin, we now provide the option to send a security code to the old email address which has to be entered to authorize the change.
+ The admin login security token now has an expiration time that can be configured.
+ Login attempts are now tracked by the session (session based attemption limit). If the user email is correct, another limit for user identifed login is available. After five attempts, a lockout for one hour is enabled by default. The max number of attempts can be configured.
+ The maximum idle time of admin users can now be configured.

There is also a new [LUYA security best practice](https://luya.io/guide/app-security) guide.

## Admin General Improvments

+ NgRest attributes can now be displayed based on conditions. Assuming you have a select with categories, this allows you to display a certain field only when a specific category is selected. [Read more](https://github.com/luyadev/luya-module-admin/blob/master/src/ngrest/base/Plugin.php#L53-L71)
+ The filemanager provides the option to switch between inline or download for file delivery. The renaming of files is now possible, too. We also made some improvements with the display of file details, including a fullscreen preview.
+ The storage system is now completely swapable: this makes using Amazon S3 possible and available as a feature [LUYA aws extension](https://github.com/luyadev/luya-aws)
+ The speed of the storage system was improved: we have significantly reduced the time it takes the admin to load the list of all files and images.
+ The general PHP docs were improved and deprecated methods were removed, see upgrade.md
+ The Roboto font used in the admin now supports (+Extended), Cyrillic (+Extended), Greek (+Extended), Vietnamese.

You can download and install LUYA admin version 1.2 (`~1.2.0` in composer). Make sure to run the `migrate` command afterwards as the update includes database migrations. See the full [changelog](https://github.com/luyadev/luya-module-admin/blob/master/CHANGELOG.md) und [upgrade](https://github.com/luyadev/luya-module-admin/blob/master/UPGRADE.md) document.

## CMS

Along with the Admin module we also released CMS module version 1.0.4, which includes:

+ Minification and uglification of Angular code.
+ New command to cleanup the cms, remove deleted pages, blocks and log files: `cms/page/cleanup`.
+ New property to provide import paths for blocks: `luya\cms\frontend\Module::$blocks`.
+ New commands to list blocks and migrate them from the console: `cms/block/find` and `cms/block/migrate`. The migrate command is helpful when you want to delete an old block but assign its contents to a new block.

22 May 2018, LUYA developer team
