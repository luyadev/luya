# Dropdown/Select Field

Generates a dropdown (select) field based on given values.

## Plugin Types

There are 3 different types of plugins:

+ {{luya\admin\ngrest\plugins\SelectArray}}: Take dropdown values from an arrayy
+ {{luya\admin\ngrest\plugins\SelectRelationActiveQuery}}: Determine Values from a Yii relation. Best performance and therefore recommend!
+ {{luya\admin\ngrest\plugins\SelectModel}}: Database Query based select, bad performance but quick setup. Should not be used when making selects in a large table.

### SelectArray

Create a dropdown selection based on an associated array:

```php
public function ngrestAttributeTypes()
{
    return [
        'genres' => ['selectArray', 'data' => [1 => 'Male', 2 => 'Female']],
    ];
}
```

### SelectRelationActiveQuery

When dealing with large tables the {{luya\admin\ngrest\plugins\SelectRelationActiveQuery}} class can handle large amount of data but there is no model callback for the label fields, it returns raw sql data. In order to use this plugin you need to have a `hasOne` relation.

```php
'user_id' => [
    'class' => SelectRelationActiveQuery::class, 
    'query' => $this->getUser(), 
    'labelField' => 'firstname,lastname'
]
```

In order to access the data through a eager loaded relation, the relation name must be omited into the config. Assuming the example above `getUser()` would return a `$this->hasOne()` relation definition the {{luya\admin\ngrest\plugins\SelectRelationActiveQuery::$relation}} property can be configured to load the data from this relation:

```php
'user_id' => [
    'class' => SelectRelationActiveQuery::class, 
    'query' => $this->getUser(),
    'relation' => 'user',
    'labelField' => 'firstname,lastname'
]
```

In order to eager load the `user` relation withing API list calls, the `with()` defintion can be configured in {{luya\admin\ngrest\base\Api::prepareListQuery()}}:

```php
public function prepareListQuery()
{
    return parent::prepareListQuery()->with(['user']);
}
```

### SelectModel

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

You can define more options for the select model like `where statements and which fields should be displayed take a look at class API {{luya\admin\ngrest\plugins\SelectModel}} for more information.

In order to generate a custom label field you can also pass a closure function:

```php
'labelField' => function($model) {
    return $model->firstname . ' ' . $model->lastname;
}
```

> **Attention** Please keep in mind this plugin will override the default values from the database to display the REST API data. To prevent such a behavior use {{luya\admin\ngrest\plugins\SelectRelationActiveQuery}} instead.
> 
> ```php
> public function getCustomer()
> {
>     return $this->hasOne(Customer::class, ['id' => 'customer_id']);
> }
> ```
> 
> The above example **will not work** if the customer_id field as the value is already observed from the `selectModel` plugin. You can always access the old data (before the after find event) like this:
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

## Handling `null` empty values

By default a **no selection** or a **reset of a currently selected** item will assign the value `null` to this field as defined in {{luya\admin\ngrest\plugins\Select::$initValue}}. This might make problem with handling empty [Yii validation rule inputs](https://www.yiiframework.com/doc/guide/2.0/en/input-validation#handling-empty-inputs) as `null` wont be threated. Therfore you could change initValue to `0` or change the validation rules to have a default value on empty:

```php
return [
    ['user_id', 'default', 'value' => 0],
];
```

This will set value to `0` if `null` value recieves the API. Or change the initValue to 0 when configure the select plugin:

```php
return [
    'user_id' => [
        'selectArray',
        'data' => [1 => 'John Doe', 2 => 'Jane Doe'],
        'initValue' => 0,
    ]
];
```

Assuming the user_id validation rule requires an integer value.
