# NgRest Model

The `NgRest` crud model class is the based class for the api, based on this Active Record class the find, update and created validation rules will be perfomed. The main different to the Yii2 Restful implementation is the to use `admin\ngrest\base\Model` as base class. So the ngrest crud model provides additianl informations to what fields you want to edit, create or list in your crud view.

![ngrest-crud](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide1.0/img/ngrest-crud.png "NgRest Image")

You should read the [Admin NgRest Crud Concept](app-admin-module-ngrest.md) in order to understand waht the NgRest Model is all about.

## Where do i configure?

Each NgRest Model does have a `ngrestAttributeTypes` method where you can define what type of fields you have and `ngRestConfig($config)` where you can define the fields for the specific pointers (crud, list, create).

#### Define attribute types

To define an attribute type for a specific attribute, you have to override the `ngrestAttributeTypes` method by returning an array where the key is the field and value the config of the [NgRest Plugin](ngrest-plugins.md).

An example of a defintions:

```php
public function ngrestAttributeTypes()
{
    return [
        'title' => ['selectArray', 'data' => ['Mr', 'Mrs']],
        'name' => 'text',
        'text' => 'textarea',
        'description' => ['textarea', 'markdown' => true],
        'timestamp' => 'date',
        'size' => 'nummeric',
    ];
}
```

A defintion contains always the attribute (as key) and the ngrest plugin config, if you have to pass arguments to the plugin object you can define an array where the first key is the name of the plugin and the other keys are the plugin properties.

#### Pointers and ngRestConfig

There are 4 specific pointers you can use to configure. A pointer as like a section of your config:* config eingestellt werden können.

|Pointer Name   |Description
|---       |---
|list      |List the data rows of the Table (like a data table)
|create    |The form to create a new data record.
|update    |Update form to update the value of an existing data record.
|delete    |Define whether items of the data table can be deleted or not. To activate deletion us `$config->delete = true`.
|aw        |[ActiveWindows](ngrest-activewindow.md) Register/add active windows, to this config. Active windows are like buttons you can add to each item record.

As you know what section/pointers you can define with your already defined attributes you have to define the `ngRestConfig` method, this could look as followed:

```php
public function ngRestConfig($config)
{
    // define fields for types based from ngrestAttributeTypes
    $this->ngRestConfigDefine($config, 'list', ['title', 'name', 'timestamp]);
    $this->ngRestConfigDefine($config, ['create', 'update'], ['title, 'name', 'text', 'desription', 'timestamp', 'size']);
    
    // enable or disable ability to delete;
    $config->delete = false; 
    
    return $config;
}
```

As you can see we use the helper method `ngRestConfigDefine` to define which *pointer* has which *attributes*.

#### Delete

To enable a delete button where the user can remove an item from the database table you can configure the delete pointer:

```php
$config->delete = true;
``` 

This will trigger the  [Yii AR delete methode](http://www.yiiframework.com/doc-2.0/yii-db-activerecord.html#delete()-detail) and removes the item irrevocable, you can override the `delete()` method to change the behavior of a deletion.

## Multlingual / i18n Fields

You can define all fields as multi lingual by setting:

```php
public $i18n = ['title', 'description'];
```

This will automatically enable to add content for all languages, and returns the content the content for the current active language in when returning the data from the model in the frontend.

When casting a field as i18n it will save the multi lingual data as json in the database.

> All i18n fields must be type of varchar or text in the database, as its json encodes the input array in the database table field.

## Soft Deletion 

We have also added a soft delete trait which is going to override the default implementation of the `delete` method. When enabled and configure, the soft delete trait will only mark the datarecord to `is_deleted = 1` instead of removing it from the database.

```php
use admin\traits\SoftDeleteTrait;
```

By default, soft delete trait will use the field `is_deleted` to find and delete data records, you can configure the field by overriding the `FieldStateDescriber` method as followed:

```php
public static function FieldStateDescriber()
{
	return [
	    'is_deleted' => [1, 0], // on delete sets `is_deleted = 1`; on find add where `where(['is_deleted' => 0]);`.
	    'is_inactive' => true, // on delete sets `is_inactive = true`; on find add where `where([is_inactive' => !true]);`.
	]
}
```