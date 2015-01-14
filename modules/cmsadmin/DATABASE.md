CMS-ADMIN
======================

CMS Database Tables
--------
+ cms_nav
+ cms_cat
+ cms_nav_item
+ cms_nav_item_page
+ cms_nav_item_redirect
+ cms_nav_item_pagealias

cms_cat (navigation category)
-----------
+ id
+ name [Footer Left]
+ rewrite [footer-left] (for accessing the navigation category inside the template, ex: $nav->getNavFromCatRewrite('footer-left'))
+ default_nav_id

cms_nav
------------
+ id
+ cat_id
+ parent_nav_id
+ sort_index
+ is_deleted [0,1]

cms_nav_item
-------------
+ id
+ nav_id
+ lang_id
+ title [Welcome Page]
+ rewrite [welcome-page]
+ nav_item_type [0,3] 1 = Page; 2 = Redirect; 3 = Application
+ nav_item_type_id [0,X] The id of the selected type table
+ is_hidden [0,1] the url still works, but well not be shown in the navigation
+ is_inactive [0,1] the url does not work (404) and it will not be shown in the navigation
+ create_user_id
+ update_user_id
+ timestamp_create
+ timestamp_update

cms_nav_item_page
-----------------
The cms_nav_item_page class must contain a start/end event, cause different behaviours must be applied by types.

+ id
+ content

cms_nav_item_redirect
---------------------
The cms_nav_item_page class must contain a start/end event, cause different behaviours must be applied by types.

+ id
+ to_url [0, VALUE]
+ to_nav_id [0, VALUE]
+ http_status
+ ...

cms_nav_item_application
----------------------
The cms_nav_item_page class must contain a start/end event, cause different behaviours must be applied by types.

+ id
+ module_name
+ ...