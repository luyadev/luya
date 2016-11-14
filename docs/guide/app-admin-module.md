Project Admin-Modul
==================

An Admin-Module provides the ability to quickly create an adminstration section for your data. The LUYA Crud System is Called [NgRest](ngrest-concept.md).

Some features available in the Admin Modules:

+ [NgRest, CRUD system based on Angular and Yii2](ngrest-concept.md)
+ {{luya\admin\components\StorageContainer}}
+ Image filters and effects
+ Apis
+ Permissions

> You can use the [Console Command](app-console.md) `module/create` to create a frontend or an admin module.

### Controller views

Inside an administration module you shoud always use `renderPartial()` method, as there is no layout views because you are in an Angular context.
