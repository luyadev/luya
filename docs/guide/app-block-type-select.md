# Selects in Blocks

Creating a select with numeric values and initvalue

```php
['var' => 'col', 'label' => 'Sizes', 'type' => 'zaa-select', 'initvalue' => 3, 'options' => [
    ['value' => 1, 'label' => '30%'],
    ['value' => 2, 'label' => '40%'],
    ['value' => 3, 'label' => '50%'],
    ['value' => 4, 'label' => '60%'],
]],
```

> Take care with the data types, do not use `"1"` when dealing with numeric values, use `1` instead otherwhise the type cast will change your values.

Using select with string values:

```php
['var' => 'name', 'label' => 'Your Name', 'type' => 'zaa-select', 'initvalue' => 'john', 'options' => [
    ['value' => 'john', 'label' => 'John Doe'],
    ['value' => 'jane', 'label' => 'Jane Doe'],
]],
```