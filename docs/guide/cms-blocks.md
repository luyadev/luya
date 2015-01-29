CMS BLOCKS
==========

Creating new CMS Blocks

JSON CONFIG
-----------

| Usabled object keys | Type   |  Description
| ------------------- | ------ | -------------
| vars				  | array  | creates a new variable with specific values 
| placeholders		  | array  | creates new placeholders (with "var" and "label" keys)

```
{
    "vars" : [
        {
            "var" : "h1",
            "label" : "Uebeschrift Inhalt",
            "type" : "zaa-input-text"
        },
        {
        	"var" : "selection",
        	"label" : "Select Box Demo",
        	"type" : "zaa-input-select",
        	"options" : [
        		{ 
        			"id" : 1, 
        			"label" : "Herr" 
    			},
        		{ 
        			"id" : 2,
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