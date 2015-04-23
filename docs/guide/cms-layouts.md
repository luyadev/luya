CMS Layouts
==========

Creating new CMS Layouts

JSON CONFIG
-----------

| Usabled object keys | Type   |  Description
| ------------------- | ------ | -------------
| placeholders		  | array  | creates new placeholders (with "var" and "label" keys)

```
{
    "placeholders" : [
    	{
    		"var" : "content", 
    		"label" : "Inhalt"
    	}
    ]
}
```

Links collection variable in Layout
-----------------------------------

By default the link collection exists in the cmslayout files.

The below example returns an array containing all links for ***cat => default***, ***language => de*** and ***parent_nav_id =>  0***:
```
{{ dump(links('default', 'de', 0)) }}
```

To get the first sub navigation of current active page node just add the dynamic parent_nav_id
```
{{ dump(links('default', 'de', activeLink.id)) }}
```
The variable activeLink returns an array containing informations about the current active link.
