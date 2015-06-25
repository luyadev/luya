LUYA CHANGELOG
==============

1.0.0-alpha7 (in progress)
--------------------------
- fixed bug in UrlManager where components are not available.
- fixed bug where modules are loaded in the module integration block.

1.0.0-alpha6 (25. Jun 2015)
--------------------------
- removed `$app->collection->links` (search for `$app->collection->links` and replace with `$app->links`).
- removed `$app->collection->composition` (search for `$app->collection->composition` and replace with `$app->collection`).
- removed `admin\Module::getData()` added `$app->adminuser`
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
- added `is_dirty` block
- fixed bug in get block where extra vars have not been reloaded.
- added preview button
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