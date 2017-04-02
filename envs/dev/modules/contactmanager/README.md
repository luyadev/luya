# Contactmanager Module
 
File has been created with `module/create` command on LUYA version 1.0.0-dev. 
 
## Installation

In order to add the modules to your project go into the modules section of your config:

```php
return [
    'modules' => [
        // ...
        'contactmanager' => 'app\modules\contactmanager\frontend\Module',
        'contactmanageradmin' => 'app\modules\contactmanager\admin\Module',
        // ...
    ],
];
```