Block config and type
=============================
Here we are going to more deeply understand what the `config()` method of a block contains and what kind of types can be used. To understand of the config first we have to explain the available types of confiugrations and which are used to be configured by the user or the developer.

Types
-----
The `config()` method returns an array with all defined types for this current block, the first level defines the block types:

```php
return [
    'vars' => [],
    'cfgs' => [],
    'placeholders' => [],
];
```

> You only have to return the types you like to use in your block, if do not have placeholders your don't have to return it at all.

| Name | Function
| ---- | --------
| vars | Contains all variables which are shown when editing the block in the administration.
| cfgs | Those options are the config gear icon in the administration overview and can contain optional informations which could be more deeply or more for the developer context.
| placeholders | Allows you to generate placeholders which creates an arra where other blocks can be dropped into, this is very common for layout blocks.

Field
-------------

Now you can add a field into the above defined type, this is like a configuration of a field which must contain `var`, `label` and `type`:

```php
[
    'var' => 'userInputText',
    'label' => 'Form Label for the User',
    'type' => 'zaa-text',
] 
```

This would create an input variable with a text input with the label `From Label for the User`. Now the type can be added into a group you like:

```php
return [
    'vars' => [
        ['var' => 'userInputText', 'label' => 'Beschreibung von userInputText', 'type' => 'zaa-text']
    ]
];
```

Input-Types
------------------

There are several types you can use instead `zaa-text` the most of them are self explaining

| Type Name             | Description
| --------------------- | -----------
| zaa-text      | create a simple string input text value field
| zaa-password  | create a input password field which hides the input value behind * signs
| zaa-textarea          | create a multirow input element known as textarea
| zaa-number | create a numerics values
| zaa-link | creates a link field for internal and external URLs
| zaa-wysiwyg | create a small wysiwg editor
| zaa-select        | create a select dropdown with options based on the options parameter. The Options item must contain a value and label key
| zaa-datetime | creates an integer value of datetime
| zaa-date | creates an integer value of a date
| zaa-checkbox | creates a single checkbox (e.g. to define on/off states)
| zaa-checkbox-array | creates an array with checkboxes
| zaa-file-upload       | creata a file upload form and returns the fileId on success
| zaa-file-array-upload | creates an array with file id and caption string
| zaa-image-upload      | creata a image upload form and return the imageId on success
| zaa-image-array-upload | creates an asrray with image id an caption string
| zaa-list-array | creates an array with a key variable `value`
| zaa-decimal           | Creates decimal input field with option: `options="{'steps':0.0001}"` to define step size. Default = 0.001.

