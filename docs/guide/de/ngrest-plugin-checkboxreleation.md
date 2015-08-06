Checkbox via Referenz Tabelle
=============================
Um eine auswahl von Datensätze über eine Referenz Tabelle zu erzeugen benutzet du das `checkboxReleation` plugin. Ein Anwnedungs Beispiel kann zum Beispiel sein wenn man Benutzer hat welche *einer oder mehrerer* Gruppen zugewiesen werden können. Man hat also 3 Tabellen:
+ user *(Benutzer)*
+ group *(Gruppen)*
+ user_group_ref *(Referenze Tabelle mit user_id und group_id)*

Dadurch das die Referenz auswahl nicht auf einem Feld liegt wird im Model ein `extraFields` eintrag benötigt. Wir möchten also auf der Gruppen ansicht (Group Model) Benutzer für einen Datensatz wählen.

```php

use admin\models\User;

class Group extends \admin\ngrest\base\Model
{	
	// ...
	
	public $extraFields = ['users'];
	
	public function scenarios()
	{
		'restcreate' => ['users', '...'],
		'restupdate' => ['users', '...'],
	}
	
	public $users = [];
	
	public function ngRestConfig($config)
	{
		// ...
		
		$config->create->extraField('users', 'Benutzer')->checkboxRelation(User::className(), 'user_group_ref', 'group_id', 'user_id', ['firstname', 'lastname', 'email'], '%s %s (%s)');
	
		return $config;
	}
}
```

> Die Variabel in `extraFields` muss mit einer public propertie übereinstimmen, also `$extraFields = ['users'];` heisst das im Model eine `public $users = [];` existieren muss.

Parameter von checkboxRelation
------------------------------

```php
checkboxRelation($model, $refJoinTable, $refModelPkId, $refJoinPkId, array $displayFields, $displayTemplate = null)
```

| Parameter | Beschreibung 	| Optional  | Beispiel
|---		|--				|---		|---
|$model|Model-Klasse welche die Gegenstück informationen der Referenzen Tabell entählt|Nein|User::className()
|$refJoinTable|Name der Referenz Tabelle|Nein|user_group_ref
|$refModelPkId|Name des Feldes innerhalb der Referenz Tabelle für den Primary Key *das Models* (= Die Klasse welche das checkboxReleation Plugin registriert wirde)|Nein|group_id
|$refJoinPkId|Name des Feldes innerhalb der Referenz Tabelle für den Primary Key der *Joinenden Tabelle* (= Die klass/Tabelle aus dem `$model`)|Nein|user_id
|$displayFields|Welche Felder aus der *Joinenden Tabelle* sollen in der Üersicht angezeigt werden.|Nein|`['firstname', 'lastname', 'email']`
|$displayTemplate|Wie soll die darstellung der Felder aus `$displayFields` aussehen, das Template wird wie `sprintf` gerendert.|Ja|`'%s %s (%s)` würde `Vorname Nachname (E-Mail)` ergeben.

