<?php
use luya\base\Boot;

?># <?= $name; ?> 
 
Date: <?= date("d.m.Y \a\t H:i"); ?> 
LUYA: <?= Boot::VERSION; ?> 

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