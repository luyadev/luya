CONVENTION MODULE
=================

1. Naming
---------
There are two type of Modules, Admin-Modules and Frontend-Modules. Admin-Modules does have an "admin" suffix.

Example
```
cmsadmin (Admin-Module)
cms (Frontend-Module)
```

2. Content
----------
Where goes the content? All shared data class (componenets, models) does have to be place in the Admin-Module section. This is because the Rest authentification is allocated in the Admin-Modules.

Example folder structure
```
cmsadmin /
- controllers
- views
- assets
- components
- models
- apis
- migrations
- straps

cms /
- controllers
- views
- assets
- components [example content: UrlRule.php, cause its only affecting the frontend Module]

```

3. Table names
--------------
Alle table names have the prefix of its FRONTEND-MODULE there there is booth or only a frontend-module. If there is only a ADMIN-Module the prefix of the table does have the same name like the module.

```
modules:
+ cmsadmin
+ cms

the database prefix would be:
cms_
```
```
modules:
+ news (no admin-module e.g.)

the database prefix would be:
news_
```
```
+ guestbookadmin (no frontend-module e.g.)

the database prefix would be:
guestbookadmin_
```