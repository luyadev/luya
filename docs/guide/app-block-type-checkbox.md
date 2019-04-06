# Single checkbox

Generate a checkbox which is **checked** by default:

```php
['var' => 'mycheckbox', 'label' => 'Check this!', 'type' => self::TYPE_CHECKBOX, 'initvalue' => 1],
```

This checkbox is **unchecked** by default:

```php
['var' => 'mycheckbox', 'label' => 'Check this!', 'type' => self::TYPE_CHECKBOX],
```

which is equals to:

```php
['var' => 'mycheckbox', 'label' => 'Check this!', 'type' => self::TYPE_CHECKBOX, 'initvalue' => 0],
```