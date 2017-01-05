# Dropdown Selection

The {{luya\admin\ngrest\plugins\SelectArray}} and {{luya\admin\ngrest\plugins\SelectModel}} plugins generate a dropdown selection list from an array or a database table.

### Select from an Array

Create a dropdown selection based on an assoc array:

```php
public function ngrestAttributeTypes()
{
	return [
		// ...
		'genres' => ['selectArray', 'data' => [1 => 'Male', 2 => 'Female']],
	];
}
```

### Select from a Model

Create a dropdown selection based on an {{yii\db\ActiveRecord}} model class:

```php
public function ngrestAttributeTypes()
{
    return [
		// ...
		'genres' => [
	     	'selectModel', 
	     	'modelClass' => Customers::className(), 
	     	'valueField' => 'customer_id', 
	     	'labelField' => 'name',
	     ],
     ];
}
```

You can define more options for the select model like where statements and which fields should be displayed take a look at class api {{luya\admin\ngrest\plugins\SelectModel}} for more informations.

In order to generate a custom labelField you can also pass a closure function:

```php
'labelField' => function($model) {
    return $model->firstname . ' ' . $model->lastname;
}
```

> **Attention** Keep in mind the plugin will override the default values from the database to display the rest api data.
> 
> ```php
> public function getCustomer()
> {
>     return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
> }
> ```
> 
> The above example **won't work** as the customer_id field is already observed from the `selectModel` plugin. You can always access the old data (before the after find event) like this:
> 
> ```php
> public function getOriginalCustomerId()
> {
> 	return $this->getOldAttribute('customer_id');
> }
>     
> public function getCustomer()
> {
> 	return $this->hasOne(Customer::className(), ['id' => 'originalCustomerId']);
> }
> ```
