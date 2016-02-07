Project Admin-Modul
==================

An Admin-Module provides you the possibility to quickl add a new adminstration for your data, the LUYA Crud System is Called [NgRest](app-admin-module-ngrest.md).

Some Features you can use in Admin Modules:

+ [NgRest, CRUD system based on Angular and Yii2](app-admin-module-ngrest.md)
+ [Storage system](https://luya.io/api/admin-components-storagecontainer.html)
+ Image filters and effects
+ Apis
+ Permissions

### Controller views

Inside an administration module you shoud always use `renderPartial()` method, as there is no layout views because you are in an Angular context.