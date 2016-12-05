# Admin Modules

An Admin Module provides the ability to quickly create an adminstration section for your data. The LUYA Crud system is called [NgRest CRUD](ngrest-concept.md).

Some features available in the Admin Modules:

+ [NgRest, CRUD system based on Angular and Yii2](ngrest-concept.md)
+ {{luya\admin\components\StorageContainer}}
+ Apis
+ [Permissions](app-admin-module-permission.md)

You can use the [Console Command](app-console.md) `module/create` to scaffold quickly all the required folders and files.

### Controller View

Inside an administration modules controller, you have to use `renderPartial()` method when rendering views, as there is no layout views because you are in an Angular context.
