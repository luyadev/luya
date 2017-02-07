# Multiple inputs

Generate a expandable list with custom plugins inside each row.

### Definition in Block

```php
['var' => 'people', 'label' => 'People', 'type' => 'zaa-multiple-inputs', 'options' => [
        [
            'type' => 'zaa-select',
            'var' => 'salutation',
            'label' => 'Salutation',
            'options' => [
                ['value' => 1, 'label' => 'Mr.'],
                ['value' => 2, 'label' => 'Mrs.'],
            ]
        ],
        [
            'type' => 'zaa-text',
            'var' => 'name',
            'label' => 'Name'
        ],
    ]
]
```

### LUYA Admin view

![Example of multiple inputs in action](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/app-block-type-multiple-inputs-example.png "Multiple inputs in action")

### Output in frontend

```php
<? print_r($this->varValue('people')); ?>

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