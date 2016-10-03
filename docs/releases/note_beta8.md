Today (11. August 2016) beta 8 of the Yii2-based content management system LUYA was released after several weeks' work! The new version provides many important additions and improvements, including:

- page permissions allow to restrict the pages a group of backend users can edit (permissions can be granted for individual pages as well as sections)
- status data can now be stored in user settings, like the collapsing of the page tree or the last location in the file manager (which are now remembered by LUYA)
- content blocks can be marked as favorites to be available at the top of the catalogue
- additional block info is available in views, answering questions like "Is this the first block in a container?" or "Is this block preceded or followed by a block of the same type?" (e.g. to open and close wrappers around a group of the same types of blocks)
- the select plugin now uses the "Chosen" jQuery plugin to make selection with long lists more comfortable (https://harvesthq.github.io/chosen/)
- PHP views can now be used as an alternative to Twig views
- dates can now be set using a date picker
- there are new shortcodes for the tag parser to include relative URLs and mail links in Markdown text (e.g. mail[info@luya.io])
- new ngrest sorting and grouping configuration options are available
- page properties can now be accessed through the menu for all pages, not only the current one
- silent modules (interactive=0) allow the automated setup of LUYA installations
- many smaller usability improvements were done
- API documentation is linked with source code on GitHub
- there's additional PHP inline documentation
- the guide was improved and amended

### These are some of our plans for the future:

- new Kickstarter and demo theme
- a complete overhaul of the administration based on Angular 2 and Bootstrap 4

And, the most important thing of all, a new LUYA logo will be unveiled soon.  ;-)

### Links

+ [How to Install](https://luya.io/guide/install)
+ [How to upgrade existing LUYA Version](https://luya.io/guide/install-upgrade)
