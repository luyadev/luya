NGREST FIELD SELECT
====================

Options
-------

| Name												| Arguments									| Description
---------------------------------------------------------------------------------------------------------------------------------------
| selectArray($assocArray)							| Creates an array based on a Assoc Array Key Value paring. Key represents the option vlaue, Label represents the option value (label). | <ul><li>***$assocArray*** Array containting a key value paringin</ul>
| selectClass($class, $valueField, $labelField) 	| Creates a select based on a model class find() method and the key pairing based on the $modelClass[value] and $modelClass[label].		| <ul><li>***$class*** the path to the class</li><li>***$valueField*** the model field which represents the select option value</li><li>***$labelField*** The model key which will be displayed</li></ul>	 


Examples
--------

```
// create select fields based on a model clas
$config->create->field("group_id", "Gruppe")->selectClass('\cmsadmin\models\BlockGroup', 'id', 'name')->required();

// create a select field based on an assoc array key value paringin
$config->create->field("title", "Anrede")->selectArray(\admin\models\User::getTitles());

```