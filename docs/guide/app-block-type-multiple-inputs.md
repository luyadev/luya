# Multiple inputs

Generate a expandable list with custom nested fields and/or plugins inside each row.

### Definition in block

```php
['var' => 'people', 'label' => 'People', 'type' => self::TYPE_MULTIPLE_INPUTS, 'options' => [
        [
            'type' => self::TYPE_SELECT,
            'var' => 'salutation',
            'label' => 'Salutation',
            'options' => [
                ['value' => 1, 'label' => 'Mr.'],
                ['value' => 2, 'label' => 'Mrs.'],
            ]
        ],
        [
            'type' => self::TYPE_TEXT,
            'var' => 'name',
            'label' => 'Name'
        ],
    ]
]
```

### LUYA admin UI

![Example of multiple inputs in action](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-block-type-multiple-inputs-example.png "Multiple inputs in action")

### Output in frontend

```php
<?php print_r($this->varValue('people')); ?>

Array (
    [0] => Array
        (
            [salutation] => 1
            [name] => Roland
        )
    [1] => Array
        (
            [salutation] => 2
            [name] => Rocky
        )
    [2] => Array
        (
            [salutation] => 1
            [name] => Marc
        )
)
```
