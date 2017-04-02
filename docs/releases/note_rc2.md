The final release of LUYA is around the corner! But for now, release candidate 2 has improved several things and fixed many bugs.

+ The administration now speaks French and Spanish, too! It is available in the following languages: German, English, Russian, French and Spanish.
+ The language of the administration can now be stored for each user individually.
+ Relational data can now be opened in new tabs in the NgRest CRUD view.
+ In the CMS there is a new page setting "SEO Title" allowing to define a custom title tag for the current page for SEO optimisations.
+ The administration module is faster due to asset files removed.
+ It is now possible to replace a file in the filemanager without its URL changing (so that links to the file keep working).
+ Files can now be dragged & dropped as well as copied & pasted to the filemenager. (Keep in mind that images and files pasted from the clipboard will receive a generic name).
+ Scaffolding became much more powerful when creating blocks, modules and executing CRUD commands. Try it out!
+ The CRUD view remembers the sorting of lists and the application of filters by storing them in the user settings.
+ Reduced memory usage within CMS blocks due to the removal of mass assignement of variables.
+ New NgRest plugin for internal and external links.
+ The crawler module was enhanced with features like setters for crawl title, groups and others. It now evaluates the description meta tag (see crawler details for more information).
+ A new property abstraction ImageProperty is now available out of the box.
+ The ngrest plugins for image, imageArray, file and fileArray have now an option in order to directly return the file/image or iterator object.
+ Blocks and other forms can now be submitted with the "Enter" key.

These are just a few of the changes with this release. We also put a lot of work into the documentation as well the luya.io website.

**We are looking for people who like to translate the administration area to other languages – please drop us a message on [Twitter](https://twitter.com/luyadev), [Gitter](https://gitter.im/luyadev/luya) or create an [issue on github](https://github.com/luyadev/luya/issues)!**

> Attention: If you want to upgrade to the second release candidate, there are a few breaking changes you have to take care of. With these changes done, we now have a stable and reliable foundation for the upcoming final release.

Please check the full [Changelog](https://github.com/luyadev/luya/blob/master/CHANGELOG.md) and the [Upgrading Guide](https://luya.io/guide/install-upgrade) where you can see all breaking changes.

If you have any problems or questions regarding the upgrade process, don't hesitate to contact us on [Gitter](https://gitter.im/luyadev/luya) or to create an [Issue on GitHub](https://github.com/luyadev/luya/issues).

29 November 2016  
LUYA developer team  
[luya.io](https://luya.io)
