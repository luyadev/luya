<?php
/**
 * @var $humanName  The human readable name.
 * @var $luyaText The markdown intro text
 * @var $name The module name (lowercase)
 * @var $ns The namespace where the module is stored in.
 */
?># <?= $humanName; ?> Module

<?= $luyaText; ?> 

## Installation

In order to add the modules to your project go into the modules section of your config:

```php
return [
    'modules' => [
        // ...
        '<?= $name; ?>frontend' => [
            'class' => '<?= $ns; ?>\frontend\Module',
            'useAppViewPath' => true, // When enabled the views will be looked up in the @app/views folder, otherwise the views shipped with the module will be used.
        ],
        '<?= $name; ?>admin' => '<?= $ns; ?>\admin\Module',
        // ...
    ],
];
```
