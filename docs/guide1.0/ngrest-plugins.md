# NgRest Config Plugins

An NgRest Plugin is like the type of an input. You can create selects, date pickers, file or image uploads, etc. Each NgRest Config Plugin can have its configuration options.

### Available Plugins

|Name				|Return		|Description
|--------------		|---		|-------------
|text				|string		|Input type text field.
|textArray			|array		|Multiple input type text fields.
|textarea		  	|string		|Textarea input type field.
|password			|string		|Input type password field.
|[selectArray](ngrest-plugin-select.md) |string	|Select Dropdown with options from input configuration.
|[selectModel](ngrest-plugin-select.md) |string	|Select Dropdown with options given from an Active Record Model class.
|toggleStatus       |integer/string	|Create checkbox where you can toggle on or off.
|image				|integer	|Create an image upload and returns the imageId from storage system.
|imageArray			|array		|Creates an uploader for multiple images and returns an array with the image ids from the storage system.
|file				|integer		|Creates a file upload and returns the fileId from the storage system.
|fileArray          |array		|Creates an uploader for multiple files and returns an array with the file ids from the storage system.
|checkboxList		|array		|Create multiple checkboxes and return the selected items as array.
|[checkboxRelation](ngrest-plugin-checkboxrelation.md) |array |Create multiple checkbox based on another model with a via table.
|date				|integer |Datepicker to choose date, month and year. Returns the unix timestamp of the selection.
|datetime 			|integer |Datepicker to choose date, month, year hour and minute. Returns the unix timestamp of the selection.
|decimal            |float	|Creates a decimal input field. First parameter defines optional step size. Default = 0.001
|number				|integer |Input field where only numbers are allowed.
|cmsPage			|\cms\menu\Item |Cms Page selection and returns the menu component item.

> Check the class reference/api guide to find out more about configuration options of the plugins.