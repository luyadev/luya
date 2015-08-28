Select Dropdown
===============
Es gibt zwei verschieden Art von Selects

+ via Assoziatives Array
+ via Model-Klasse

|Plugin		|Beschreibung
|---		|---
|`selectArray(array $assocArray, $initValue = null)` |Ein Array wobei der Schlüssel(Key) des zu setzendes Wertes entspricht und der Inhalt(Value) dem angezeigten Label.
|`selectClass($class, $valueField, $labelField, $initValue = null)` |Ein Model-Klasse erzeugt die Ausgabe Daten. *$valueField* enspricht dem Feld welches den Wert setzt, *labelField* enstpricht dem Feld welches das label darstellt.

Assoziatives Array
-----------------

```php
public function ngRestConfig($config)
{
	// ...
	$config->list->selectArray([
		'key1' => 'Label 1',
		'key2' => 'Label 2',
	]);
	
	return $config;
}
```

Model-Klasse
------------

```php
public function ngRestConfig($config)
{
	// ...
	$config->list->selectClass(\admin\models\User::className(), 'id', 'firstname');
	
	return $config;
}
```