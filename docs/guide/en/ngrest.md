NGREST
============

What is NG-REST?
----------------
NG-Rest is the luya CRUD Configurator for REST APIS. Basicaly create the api and configure the crud (cread, read, update & delete) via the ng-rest configuration and you will get a fully functional Angular Crud Manager.

Where?
--------
All the ngrest configurations are made directly in the Model class. Create a ngRestConfig($config) method inside the controller to modify your configuration. By default a configuration object is passed directly into this method.

```php
public function ngRestConfig($config)
{
    // here you can add, modify, delete your config
    $config->list->field("title", "Title")->text;
    
    // at the end just return the config variable back
    return $config;
}
```

Multilingual fields
-------------------
If you want to have multilingual fields based on the system (admin) language table you can just pass the variable ***$i18n*** an array containing are fields which should be translated. like this:

```php
class Model extends \admin\ngrest\base\Model
{
    public $i18n = ['title', 'description']; // will transform those field into multilingual fields
}
```

Configuration Pointers
--------------------
The ng-rest config pointers describes the "scene" where the to configure fields should appear. Available pointers are:
* ***list*** This pointer describes the moment when the fields are listed in the grid view (tabelaric list)
* ***create*** This pointer descibtes the "create new entry" form.
* ***update*** This pointer describtes the "update existing entry" form.
* ***aw*** This pointer describes the attached "buttons and actions" forms.
* ***delete*** Enable the delete button to the model coresponding `delete()` method.

For example if you want to add the fields ***title*** and ***description*** into the list and create pointers just put:

```php
public function ngRestConfig($config)
{
    $this->list->field("title", "Title");
    $this->list->field("description", "Description");
    
    $this->create->field("title", "Title");
    $this->create->field("description", "Description");
}
```

The fields title and description are now configure in the list and create actions. So you could now see the fields in the grid view and you could create new entrys for those two fields.

If you want to see all configuration possibilitys after field, have a look at the [NGREST FIELDS CONFIGURATIOn GUIDE](start-ngrest-fields.md).

Delete
------
If you set `$config->delete = true` the remove/delete button will be display. Be default the *ActiveRecord* Model will now execute the `delete()` [yii AR delete](http://www.yiiframework.com/doc-2.0/yii-db-activerecord.html#delete()-detail) from the model. If you only want to set an element to `is_hidden=1` you have to **override** the `delete()` method.

Instead of override the `find()` and `delete()` method you can also use the `admin\traits\SoftDeleteTrait` trait. If you want to change the trait properites implement `public static SoftDeleteValues()` to your model and return the specific key values for the delete behavior. The find behavior will automatically be inverted from the delete values.