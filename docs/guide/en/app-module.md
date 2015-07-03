MODULE
=================

Naming
---------
There are two type of Modules, Admin-Modules and Frontend-Modules. Admin-Modules does have an "admin" suffix.

Example
```
cmsadmin (Admin-Module)
cms (Frontend-Module)
```
Module Class
--------------
All modules require a `Module.php` file inside of the module folder.

The code below is an example for a contact module inside your application.
```php
namespace app\modules\contact;

class Module extends \luya\base\Module
{
    // add your module properties
}
```

Update Config
-----------------------
Add the Module to your configuration array (config/prep.php e.g.)
```php
$config = [
    'modules' => [
        'contact'=> 'app\modules\contact\Module'
    ]
];
```

Contents
----------
All shared classes (components, models) have to be stored in the Admin-Module. This is because the rest authentification is allocated in the Admin-Modules.

admin module example structure (contactadmin):
```
.
├── controllers
├── views
├── assets
├── components
├── models
├── apis
├── migrations
└── aws (active windows)
```

frontend module example structure (contact):
```
.
├── controllers
├── assets
└── components (example content: UrlRule.php, cause its only affecting the frontend Module)
```

Database table naming convention
------------------------------
- All tables have the prefix of its FRONTEND-MODULE
- If there is only an ADMIN-MODULE the table prefix have to be the same name as the Module.

Examples:
- for the modules __contact__ and __contactadmin__ the database prefix would be __contact__.
- for the module __companyadmin__ (CRM) the database prefix would be __companyadmin__.