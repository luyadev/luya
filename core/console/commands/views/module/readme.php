<?php


?># <?= $humanName; ?> Module
 
<?= $luyaText; ?> 
 
## Installation

In order to add the modules to your project go into the modules section of your config:

```php
return [
    'modules' => [
        // ...
        '<?= $name; ?>' => '<?= $ns; ?>\frontend\Module',
        '<?= $name; ?>admin' => '<?= $ns; ?>\admin\Module',
        // ...
    ],
];
```