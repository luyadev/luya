CMS BLOCKS
==========

Creating new CMS Blocks

JSON CONFIG
-----------

| Usabled object keys | Type   |  Description
| ------------------- | ------ | -------------
| vars				  | array  | create a new variable with specific values. each var item object must contain: var, label and type
| placeholders		  | array  | creates new placeholders (with "var" and "label" keys)

```
{
    "vars" : [
        {
            "var" : "h1",
            "label" : "Uebeschrift Inhalt",
            "type" : "zaa-text"
        },
        {
        	"var" : "selection",
        	"label" : "Select Box Demo",
        	"type" : "zaa-select",
        	"options" : [
        		{ 
        			"value" : 1, 
        			"label" : "Herr" 
    			},
        		{ 
        			"value" : 2,
        			"label" : "Frau"
    			}
        	]
        }
    ],
    "placeholders" : [
    	{
    		"var" : "content", 
    		"label" : "Inhalt"
    	}
    ]
}
```

AVAILABLE VAR TYPES
-------------------

| Type Name				| Description
| --------------------- | -----------
| zaa-text		| create a simple string input text value field
| zaa-password	| create a input password field which hides the input value behind * signs
| zaa-textarea			| create a multirow input element known as textarea
| zaa-number | create a numerics values
| zaa-wysiwyg | create a small wysiwg editor
| zaa-select		| create a select dropdown with options based on the options parameter. The Options item must contain a value and label key
| zaa-datetime | creates an integer value of datetime
| zaa-date | creates an integer value of a date
| zaa-checkbox-array | createa an array with checkboxes
| zaa-file-upload		| creata a file upload form and returns the fileId on success
| zaa-file-array-upload | creates an array with file id and caption string
| zaa-image-upload		| creata a image upload form and return the imageId on success
| zaa-image-array-upload | creates an asrray with image id an caption string
| zaa-list-array | creates an array with a key variable `value`


TWIG FRONTEND
------------

| Availabes vars | Type   |  Description
| ------------------- | ------ | -------------
| vars				  | array  | Returns an array with all the ***rendered*** vars in JSON Config. The return a specific value use: {{ vars.h1 }}
| placeholders		  | array  | Returns an array with all the ***rendered*** placeholder containers. The return a specifigc use: {{ placeholders.content }}

```
<h1 class="{{vars.class}}">{{ vars.h1 | e}}</h1>
<div>
	<!-- recursive rendering -->
	{{ placeholders.content }}
</div>
```


TWIG ADMIN
-----------

| Availables Vars | Content
| --------------- | ------- 
| vars			  | Contains all the rendered variables defined in the json config. for example to output the previous mentiond h1 variable use vars.h1
| block			  | contains the current block item with the following variables <ul><li>***id*** </li><li>***vars*** containing all the variables from vars. Example of accessing the options array from json config like this: block.vars.0.options</li><li>***name*** block name from the database</li><li>***twig_admin*** the twig admin content itself (which your currently working)</li><li>***values*** the values which have been generated from the database (not like vars.name which are directly beeing refreshed by angular).</li></ul>

```
<h1>{{ vars.h1 }}</h1>
<p>{{ block }}</p>
```