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
    $config->list->field("title", "Title")->text->required();
    
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
* ***delete*** ***TBD***

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