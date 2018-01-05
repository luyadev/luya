# Dropdown selection

The {{luya\admin\ngrest\plugins\SelectArray}} and {{luya\admin\ngrest\plugins\SelectModel}} plugins generate a dropdown selection list from an array or a database table.

### Select from an Array

Create a dropdown selection based on an associated array:

```php
public function ngrestAttributeTypes()
{
    return [
        // ...
        'genres' => ['selectArray', 'data' => [1 => 'Male', 2 => 'Female']],
    ];
}
```

### Select from a model

Create a dropdown selection based on a {{yii\db\ActiveRecord}} model class:

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

You can define more options for the select model like `where statements and which fields should be displayed take a look at class api {{luya\admin\ngrest\plugins\SelectModel}} for more information.

In order to generate a custom label field you can also pass a closure function:

```php
'labelField' => function($model) {
    return $model->firstname . ' ' . $model->lastname;
}
```

> **Attention** Please keep in mind the plugin will override the default values from the database to display the rest api data.
> 
> ```php
> public function getCustomer()
> {
>     return $this->hasOne(Customer::class, ['id' => 'customer_id']);
> }
> ```
> 
> The above example **will not work** if the customer_id field is already observed from the `selectModel` plugin. You can always access the old data (before the after find event) like this:
> 
> ```php
> public function getOriginalCustomerId()
> {
>     return $this->getOldAttribute('customer_id');
> }
>     
> public function getCustomer()
> {
>     return $this->hasOne(Customer::class, ['id' => 'originalCustomerId']);
> }
> ```

## SelectRelationActiveQuery

When dealing with large tables the {{luya\admin\ngrest\plugins\SelectRelationActiveQuery}} class can handle large amount of data but there is no model callback for the label fields, it returns raw sql data. In order to use this plugin you need to have a `hasOne` relation.

```php
'user_id' => [
    'class' => SelectRelationActiveQuery::class, 
    'query' => $this->getUser(), 
    'labelField' => 'firstname,lastname'
]
```
