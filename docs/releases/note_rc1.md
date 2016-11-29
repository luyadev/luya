We are proud to announce the first release candidate (1.0.0-RC1) of LUYA after weeks of intensive work. These are the most significant changes and additions:

+ The administration is loading at least twice as fast as before
+ Composer update has been speed up significantly by removing old dependencies (including bower dependencies)
+ Core classes and modules have been reorganized to optimize system architecture
+ Configuration file naming has been changed to improve clarity
+ cms, news and crawler modules now combine admin and frontend submodules so that only one composer package is required
+ Introduced tag mechanism to allow for special codes in text fields that are parsed and replaced with any thinkable type of content
+ Introduced block injectors that inject related and preprocessed data into a CMS block (the link inspector, as an example, can provide an URL based on a link value stored within a block)
+ Introduced the Lazyload widget that loads images only when they scroll into view
+ CMS pages can now be copied with their content blocks and languages
+ Textareas do now automatically resize vertically according to their content
+ NgRest Crud lists automatically activate pagination when there are more than 250 rows (this behavior can be configured)
+ Search results can be grouped by content type (this is configured adding CRAWL_GROUP meta information to the source code)
+ Tons of bug fixes and small improvements

> Attention: If you want to upgrade to the first release candidate, there are a few breaking changes you have to take care of. With these changes done, we now have a stable and reliable foundation for the upcoming release candidates and the final release.

Please check the full [Changelog](https://github.com/luyadev/luya/blob/master/CHANGELOG.md) and the [Upgrading](https://luya.io/guide/install-upgrade) Guide.

If you have any problems or questions regarding the upgrade process, don't hesitate to contact us on [Gitter](https://gitter.im/luyadev/luya) or to create an [Issue on GitHub](https://github.com/luyadev/luya/issues).

4 October 2016  
LUYA developer team
