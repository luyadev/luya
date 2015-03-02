MODULE
=================

1. Naming
---------
There are two type of Modules, Admin-Modules and Frontend-Modules. Admin-Modules does have an "admin" suffix.

Example
```
cmsadmin (Admin-Module)
cms (Frontend-Module)
```
2. Module File
--------------

Create "Module.php" inside module root

Example

```php
    namespace app\modules\cmsadmin;

    class Module extends \luya\base\Module
    {
        public static $urlRules = [];
    }
```


3. Update Configuration
-----------------------

Update "config/local.php" with path to module.php

Example

```
    $config = ['modules' => ['myModule'=> 'app\modules\myModule\Module']]
```

***Important***

The used namespace in Module.php must match config entry

4. Content
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
- - 
cms /
- controllers
- views
- assets
- components [example content: UrlRule.php, cause its only affecting the frontend Modu
- le]
```

5. Table names
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

6. Module urlRules
-----------------
Each Module can have its own url Rules. Even its not access by module context, example ulrRules

```php
    public static $urlRules = [
        ['pattern' => 'estore/testof/<id:\d+>', 'route' => 'estore/default/debug'],
        ['pattern' => 'estore/xyz', 'route' => 'estore/default/debug'],
    ];
```

You can also have composition url rules which will also match against the ***collection->composition->getFull()*** url, like this:

```php

    public static $urlRules = [
        ['pattern' => 'estore/warenkorb', 'route' => 'estore/default/basket', 'composition' => 
        	[
	            'en' => 'estore/the-basket',
	            'de' => 'estore/der-warenkorb'
        	]
        ],
    ];
```

those rules above will also match against the en/de compsition full url if there is any.

***Important***

All the luya module urlRules does have to "prefix" theyr pattern with the current module name, otherwise the urlRouting would load the default module registered for this project. (like cms)

7. Module Context
-------------------
If a module is invoke by another module the context variable contains the name of the module which has invoke the active module. For example if the cms loades other modules, the loaded module can access the 
parent module with $this->getContext();