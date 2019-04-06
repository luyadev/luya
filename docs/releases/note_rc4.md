Finally – with this LUYA release, the new admin UI is available!

It took us almost half a year to develop and integrate the new admin UI. We rewrote all HTML and CSS files on the basis of the Bootstrap 4 framework (which will make it easier for developers to style their own extensions to the LUYA backend). There was also plenty of work involved adapting the AngularJS scripts.

![LUYA RC4 Admin](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/luya-rc4.png)

Initially we had planned to release LUYA version 1.0.0 at this time, but the new admin UI brings too many changes, so that we are depending on all LUYA developers to report bugs and missing features. Therefore this is RC4.

What else has been done?

+ You can now arrange placeholders within a grid system in the admin, which means you can reflect your frontend layout using rows and columns.
+ The Composer plugin can now load blocks and bootstrap files from composer.json.
+ Modules can now have custom dashboard objects: simply generate a dashboard object from your admin module (e.g. to display latest news, last logins etc.).
+ New Import and Export helper classes let you conveniently import and export CSV files (other formats to follow).
+ The admin UI now includes a developer toolbar which tracks all requests.
+ New and extended scaffolding commands let you create filters, active windows and cruds easier and with better results.
+ PostgreSQL support was added.
+ Additional ngrest plugins were added, including CheckboxRelationActiveQuery, Sortables and a beautiful Color Wheel.
+ Administration file uploading is now more secure.

We think that with this release – which encompasses over 700 commits! – we have taken LUYA a big step forward towards the goal of being one of the most versatile and easy-to-use content management systems and web application toolboxes in the Yii and PHP universes.

**Let us know about your LUYA projects! We will happily feature them on the luya.io website. For ways to contact us, see below.**

**We are looking for people who like to translate the administration area to other languages – please drop us a message on [Twitter](https://twitter.com/luyadev), [Gitter](https://gitter.im/luyadev/luya), [Slack](https://slack.luya.io/) or create an [issue on github](https://github.com/luyadev/luya/issues)!**

Please check the full [Changelog](https://github.com/luyadev/luya/blob/master/CHANGELOG.md) and the [Upgrading Guide](https://luya.io/guide/install-upgrade) where you will find a list of all breaking changes.

If you have any problems or questions regarding the upgrade process, don't hesitate to create an [issue on GitHub](https://github.com/luyadev/luya/issues).

5 September 2017  
LUYA developer team  
[luya.io](https://luya.io)
