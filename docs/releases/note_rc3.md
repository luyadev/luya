**WIP**

We have decided to make another Release Candidate before the upcoming first stable release. As we have changed so many codes and upgraded to latest Angular version we need all the important feedback from the young and growing LUYA community.

This release brings a lot of API breaking changes, so make sure to check the [Changelog](https://github.com/luyadev/luya/blob/master/CHANGELOG.md) and the [Upgrading Guide](https://luya.io/guide/install-upgrade) before upgrading to RC3.

What have we done then?

+ LUYA CONTENT PROXY: Hola! This is an awesome feature, blieve us! It allows you to sync a production environment with your local env just with one command - `./vendor/bin/luya admin/proxy` - database and files/images will be synchronised depending on your local migration status. There is a new guide section about you can read more and see an image: https://luya.io/guide#
+ The Crawler module has now a more advance search and sort algorithm including word stemming.
+ The admin interface got some new file manager colors, the top main navigation is polished and is more unified then before.
+ File selection and link selection directives got a fresh update.
+ Define the 404 Page inside the administration view. Create new page, go to cms settings an select the error page.
+ Ability to change the main layout file for a given page.
+ Variation/Flavors for blocks can be configure in the config file in order to override and hide fields.
+ Toggle Status ngRest Plugin directly toggle ability inside the list overview.
+ Added Hook component which is similiar tYii Events but with less implementation "pain". Very usefull for Projects only with luya core module.
+ Administration interface display now what user is editing what element on the page and also lockes those data items in order to prevent multi editing of the same data record.

New languages are available for all LUYA core modules:

+ Greek
+ Uktrain
+ Italien
+ Vietnamese
+ Portugese

Thanks to all those great people out there taking time to translate LUYA!

In the background:

+ Refactored core files, renamed core files to have consistent namings.
+ Dropped the TWIG templating as it just requires more RAM, adds another complexitiy behavior and makes the luya experience inconsitent.
+ Upgrade to the latest materialize and Angular Version.
+ The ngrest configs are no longer stored in the session, so we can now use closure functions.
+ Added Arrayable implementation for Menu, File, Image and Filters Object.
+ Styleguide module can now mock the function arguments to generate a more accurate styleguide.

Over 600 commits and 100 Issues!

**We are looking for people who like to translate the administration area to other languages – please drop us a message on [Twitter](https://twitter.com/luyadev), [Gitter](https://gitter.im/luyadev/luya) or create an [issue on github](https://github.com/luyadev/luya/issues)!**

> Attention: If you want to upgrade to the third release candidate, there are a few breaking changes you have to take care of. With these changes done, we now have a stable and reliable foundation for the upcoming final release.

Please check the full [Changelog](https://github.com/luyadev/luya/blob/master/CHANGELOG.md) and the [Upgrading Guide](https://luya.io/guide/install-upgrade) where you can see all breaking changes.

If you have any problems or questions regarding the upgrade process, don't hesitate to contact us on [Gitter](https://gitter.im/luyadev/luya) or to create an [Issue on GitHub](https://github.com/luyadev/luya/issues).

11 April 2017  
LUYA developer team  
[luya.io](https://luya.io)
