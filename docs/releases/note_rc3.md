We decided to make another Release Candidate before the upcoming first stable release. As we have changed large amounts of code and upgraded to the latest Angular version, we need the important feedback from the young and growing LUYA community.

This release brings a lot of API breaking changes, so make sure to check the [Changelog](https://github.com/luyadev/luya/blob/master/CHANGELOG.md) and the [Upgrading Guide](https://luya.io/guide/install-upgrade) before upgrading to RC3.

What are the most important improvements?

The new LUYA Content Proxy in action:

![luya-proxy](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/luya-proxy.gif "LUYA Proxy Sync")

+ LUYA CONTENT PROXY: Hola! This is an awesome feature, believe us! It allows you to sync a production environment with your local environment just with one command: `./vendor/bin/luya admin/proxy`. Database tables and files/images will be synchronised according to your local migration status. There is a new guide section where you can read more about this feature (Work in Progress): https://luya.io/guide/concept-depandsync
+ The Crawler module now has a more sophisticated search and sort algorithm including word stemming.
+ The admin interface got some new file manager colors, the top main navigation is more polished and consistent than before.
+ File and link selection directives got updated to improve usability.
+ The 404 error page can now be specified inside the administration view: create the page that should serve as a 404 error page, go to CMS settings an select this page.
+ The main layout file can now be changed for a page.
+ It is now possible to specify block variations in the config file in order to override and hide fields. This will reduce the number of blocks needed to cover different design situations (e.g. text styles in the text block).
+ The Toggle Status ngRest plugin can now be directly toggled inside the list view.
+ Added a hook component which is similiar to Yii events but easier to implement. Very useful for projects using only the luya core module.
+ The administration interface now displays which user is editing which element on the current page and locks edited records in order to prevent concurrent editing and data overwriting.

New languages are available for all LUYA core modules:

+ Greek
+ Uktrainian
+ Italian
+ Vietnamese
+ Portuguese

A big Thank You to all the great developers taking time to translate LUYA!

The following are some of the "under the hood" changes:

+ Refactored core files, renamed core files to have consistent naming.
+ Dropped the TWIG templating as it requires more RAM, adds an additional complexity level and makes the LUYA experience inconsistent.
+ Upgraded to the latest Materialize and Angular versions.
+ ngrest configs are no longer stored in the session, so we can now use closure functions.
+ Added Arrayable implementation for Menu, File, Image and Filter objects.
+ Styleguide module can now populate function arguments to generate a more accurate styleguide.

Over 600 commits and 100 issues!

**We are looking for people who like to translate the administration area to other languages – please drop us a message on [Twitter](https://twitter.com/luyadev), [Gitter](https://gitter.im/luyadev/luya) or create an [issue on github](https://github.com/luyadev/luya/issues)!**

> Attention: If you want to upgrade to the third release candidate, there are a few breaking changes you have to take care of. With these changes done, we now have a stable and reliable foundation for the upcoming final release.

Please check the full [Changelog](https://github.com/luyadev/luya/blob/master/CHANGELOG.md) and the [Upgrading Guide](https://luya.io/guide/install-upgrade) where you can see all breaking changes.

If you have any problems or questions regarding the upgrade process, don't hesitate to contact us on [Gitter](https://gitter.im/luyadev/luya) or to create an [issue on GitHub](https://github.com/luyadev/luya/issues).

11 April 2017  
LUYA developer team  
[luya.io](https://luya.io)
