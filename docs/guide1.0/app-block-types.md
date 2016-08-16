# Block config and type

Here we are going to more deeply understand what the `config()` method of a block contains and what kind of types can be used. To understand of the config first we have to explain the available types of confiugrations and which are used to be configured by the user or the developer.

### Types

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

### Field


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
        ['var' => 'userInputText', 'label' => 'Description of userInputText', 'type' => 'zaa-text']
    ]
];
```

## Input-Types


There are several types you can use to generate your block controllers and inputs:

|Type Name            |Description
|---------------------|-----------
|zaa-text|Create a simple string input text value field.
|zaa-password|Create a input password field which hides the input value behind * signs
|zaa-textarea|Create a multirow input element known as textarea
|zaa-number|Create a numerics values
|zaa-link|Create a link field for internal and external URLs
|zaa-wysiwyg|Create a small wysiwg editor
|[zaa-select](app-block-type-select.md)|Create a select dropdown with options based on the options parameter. The Options item must contain a value and label key
|zaa-date|Create a datepicker where the user can choose a date, the response inside the block will be a unix timestamp.
|zaa-datetime|Create a datepicker where the user can choose a date and provide an additional time, the response inside the block will be a unix timestamp.
|[zaa-checkbox](app-block-type-checkbox.md)|Create a single checkbox (e.g. to define on/off states)
|[zaa-checkbox-array](app-block-type-checkbox-array.md)|Create an array with checkboxes
|zaa-file-upload|Create a file upload form and returns the fileId on success
|zaa-file-array-upload|Create an array with file id and caption string
|zaa-image-upload|Create a image upload form and return the imageId on success
|zaa-image-array-upload|Create an asrray with image id an caption string
|zaa-list-array|Create an array with a key variable `value`
|zaa-decimal|Create decimal input field with option: `options="{'steps':0.0001}"` to define step size. Default = 0.001.

## Injectors

> Injectors are available since 1.0.0-rc1

A very common scenario is to collect data from an active record model, display the items and select them (via select or checkbox for example) and then access the selected model rows via extraVars. To achieve this a lot of code is required inside your blocks, which is good to understand what and why things happens. But if you need to get results quickly injectors are going to help you manage this kind of tasks.

Injectors can, as the name already says, inject data into your `config()` method and assign custom data to `extraVars()`.

Lets assume we have news articles from an ActiveRecord model you want to select insdie the administration area and return the selected model rows, now you can defined via the `injectors()` method a new injector:

```php
class MyBlock extends \cmsadmin\base\PhpBlock
{
	// ...
	
	public function injectors()
	{
	    return [
	        'newsData' => new cms\injector\ActiveQueryCheckboxInjector([
	            'query' => \news\models\Article::find(),
	            'type' => self::VAR_INJECTOR,
	        ]);
	    ];
	}
	
	// ...
}
```

Now the generated injector ActiveQueryCheckboxInjector is going to grab all informations from the defined query and assign them into the extra var `newsData`. Now you can access `$extras['newsData']` which returns all seleced rows from the checkbox you have assigend.

For example your view file could now look like this:

```php
foreach ($extras['newsData'] as $model) {
	echo $model->title; // assuming title is an attribute of the Article model defined in the query part of the injector.
}
```

The following Injectors are currently available:

|Class		|Description
|---		|---
|`cms\injector\ActiveQueryCheckboxInjector`|Generate as checkbox selection from an ActiveRecord and assignes selected model rows into the extraVars section.