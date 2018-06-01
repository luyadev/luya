# Select array in blocks

Creating a select with numeric values and init value

```php
['var' => 'col', 'label' => 'Sizes', 'type' => self::TYPE_SELECT, 'initvalue' => 3, 'options' => [
    ['value' => 1, 'label' => '30%'],
    ['value' => 2, 'label' => '40%'],
    ['value' => 3, 'label' => '50%'],
    ['value' => 4, 'label' => '60%'],
]],
```

> Take care with the data types, do not use `"1"` when dealing with numeric values, use `1` instead otherwise the type cast will change your values.

Using select with string values:

```php
['var' => 'name', 'label' => 'Your Name', 'type' => self::TYPE_SELECT, 'initvalue' => 'john', 'options' => [
    ['value' => 'john', 'label' => 'John Doe'],
    ['value' => 'jane', 'label' => 'Jane Doe'],
]],
```

The {{\luya\cms\helpers\BlockHelper}} provides you an optimized markup for the select options array.

```php
 ['var' => 'width', 'label' => 'Width', 'type' => self::TYPE_SELECT, 'options' => BlockHelper::selectArrayOption(
     [
         1 => '1/3 Column',
         2 => '2/3 Column',
         3 => '2/3 Column',
     ]
 )],
 ```
