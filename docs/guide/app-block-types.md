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
    'type' => 'zaa-text', // or as class constant: self::TYPE_TEXT
] 
```

This would create an input variable with a text input with the label `From Label for the User`. Now the type can be added into a group you like:

```php
return [
    'vars' => [
        ['var' => 'userInputText', 'label' => 'Description of userInputText', 'type' => self::TYPE_TEXT]
    ]
];
```

## Input-Types


There are several types you can use to generate your block controlls. Each class which support those types implements the {{\luya\admin\base\TypesInterface}} where you can use the type names as constant.

|Type Name            |Constante|Description
|---------------------|---------|-----------
|zaa-text|TYPE_TEXT|Create a simple string input text value field.
|zaa-textarea|TYPE_TEXTAREA|Create a multirow input element known as textarea
|zaa-password|TYPE_PASSWORD|Create a input password field which hides the input value behind * signs
|zaa-number|TYPE_NUMBER|Create a numerics values
|zaa-decimal|TYPE_DECIMAL|Create decimal input field with option: `options="{'steps':0.0001}"` to define step size. Default = 0.001.
|zaa-link|TYPE_LINK|Create a link field for internal and external URLs
|zaa-wysiwyg|TYPE_WYSIWYG|Create a small wysiwg editor
|[zaa-select](app-block-type-select.md)|TYPE_SELECT|Create a select dropdown with options based on the options parameter. The Options item must contain a value and label key. Example `[["value" => "v1", "label" => "Value 1"], ["value" => "v2", "label" => "Value 2"]]`.
|zaa-date|TYPE_DATE|Create a datepicker where the user can choose a date, the response inside the block will be a unix timestamp.
|zaa-datetime|TYPE_DATETIME|Create a datepicker where the user can choose a date and provide an additional time, the response inside the block will be a unix timestamp.
|[zaa-checkbox](app-block-type-checkbox.md)|TYPE_CHECKBOX|Create a single checkbox (e.g. to define on/off states)
|[zaa-checkbox-array](app-block-type-checkbox-array.md)|TYPE_CHECKBOX_ARRAY|Create an array with checkboxes
|zaa-file-upload|TYPE_FILEUPLOAD|Create a file upload form and returns the fileId on success
|zaa-file-array-upload|TYPE_FILEUPLOAD_ARRAY|Create an array with file id and caption string
|zaa-image-upload|TYPE_IMAGEUPLOAD|Create a image upload form and return the imageId on success
|zaa-image-array-upload|TYPE_IAGEUPLOAD_ARRAY|Create an asrray with image id an caption string
|zaa-list-array|TYPE_LIST_ARRAY|Create an array with a key variable `value`

### Examples with Types

Example for file download (file upload) and Markdown text for textarea inputs.

```php
public function config()
{
    return [
        'vars' => [
             ['var' => 'image', 'label' => 'Image', 'type' => self::TYPE_IMAGEUPLOAD, 'options' => ['no_filter' => true]],
             ['var' => 'text', 'label' => 'Text', 'type' => self::TYPE_TEXTAREA],
             ['var' => 'download', 'label' => 'Download', 'type' => self::TYPE_FILEUPLOAD],
        ],
    ];
}

public function getText()
{
    return TagParser::convertWithMarkdown($this->getVarValue('text'));
}

public function extraVars()
{
    return [
        'text' => $this->getText(),
        'image' => BlockHelper::imageUpload($this->getVarValue('image'), false, true),
        'download' => BlockHelper::fileUpload($this->getVarValue('download'), true),
    ];
}
```
`
In the view you can access the values as follwed:

```php
<?php if ($this->extraValue('download') && $this->extraValue('image')): ?>
    <img src="<?= $this->extraValue('image')->source; ?>" />
    <?= $this->extraValue('text'); ?>
    <a href="<?= $this->extraValue('download')->source; ?>">Download File</a>
<?php endif; ?>

## Injectors

A very common scenario is to collect data from an active record model, display the items and select them (via select or checkbox for example) and then access the selected model rows via extraVars. To achieve this a lot of code is required inside your blocks, which is good to understand what and why things happens. But if you need to get results quickly injectors are going to help you manage this kind of tasks.

Injectors can, as the name already says, inject data into your `config()` method and assign custom data to `extraVars()`.

Lets assume we have news articles from an ActiveRecord model you want to select insdie the administration area and return the selected model rows, now you can defined via the `injectors()` method a new injector:

```php
class MyBlock extends \luya\cms\base\PhpBlock
{
	// ...
	
	public function injectors()
	{
	    return [
	        'newsData' => new \luya\cms\injectors\ActiveQueryCheckboxInjector([
	            'query' => \luya\news\models\Article::find(),
	            'label' => 'title', // This attribute from the model is used to render the admin block dropdown selection.
	            'type' => self::INJECTOR_VAR,
	        ])
	    ];
	}
}
```

Now the generated injector ActiveQueryCheckboxInjector is going to grab all informations from the defined query and assign them into the extra var `newsData`. Now you can access `$extras['newsData']` which returns all seleced rows from the checkbox you have assigend.

> In order to append the injected variable to the end of the form use `'append' => true`.

For example your view file could now look like this:

```php
foreach ($this->extraValue('newsData') as $model) {
	echo $model->title; // assuming title is an attribute of the Article model defined in the query part of the injector.
}
```

The following Injectors are currently available:

|Class		|Description
|---		|---
|{{\luya\cms\injectors\ActiveQueryCheckboxInjector}}|Generate as checkbox selection from an ActiveRecord and assignes selected model rows into the extraVars section. In order to select only a specific fields add the `select()` to the ActiveRecord find ActiveQuery.
|{{\luya\cms\injectors\LinkInjector}}|Generate an ability to select a link and returns the correct url to the link based on the user selection.