CONCEPTS
===========


BLOCK (CONCEPTION)
----------------------

genrate blocks with twig and json as definition:

```json
{
	"vars" : {
		"title" 			: { "type" : "text" },
		"longMessage" 		: { "type" : "longtext" },
		"title" 			: { "type" : "arrayData", "data" : { "Herr" , "Frau" } },
		"newsItems" 		: { "type" : "arrayDataProvider", "data" : { "source" : "@<module_name>/<controller_name>/<action_name>" } }, 
	},
	"cfg" : {
		"className"			: { "type" : "text" },
		"themeSelection" 	: { "type" : "arrayData", "data" : { "Grey", "Brown", "Blue" } }
	}
}
```


```php
/*
        $loader = new \Twig_Loader_String();
        $twig = new \Twig_Environment($loader);
        
        
        $file =\Yii::getAlias('@app') . DIRECTORY_SEPARATOR ."<path_to>heading.json";
        $data = file_get_contents($file);
        $json = json_decode($data, true);
```