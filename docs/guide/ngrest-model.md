# NgRest Model

The `NgRest` crud model class is the based class for the api, based on this Active Record class the find, update and created validation rules will be perfomed. The main different to the Yii2 Restful implementation is the to use {{luya\admin\ngrest\base\NgRestModel}} as base class. So the ngrest crud model provides additianl informations to what fields you want to edit, create or list in your crud view.

> You should read the [Admin NgRest Crud Concept](ngrest-concept.md) in order to understand what the NgRest Model is all about.

## Where do i configure?

Each NgRest Model does have a {{luya\admin\ngrest\base\NgRestModel::ngrestAttributeTypes}} method where you can define what type of fields you have and {{luya\admin\ngrest\base\NgRestModel::ngRestConfig}} where you can define the fields for the specific Scope (crud, list, create).

#### Define attribute types

To define an attribute type for a specific attribute, you have to override the {{luya\admin\ngrest\base\NgRestModel::ngrestAttributeTypes}} method by returning an array where the key is the field and value the config of the [NgRest Plugin](ngrest-plugins.md).

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
        'size' => 'number',
    ];
}
```

A defintion contains always the attribute (as key) and the ngrest plugin config, if you have to pass arguments to the plugin object you can define an array where the first key is the name of the plugin and the other keys are the plugin properties. Take a look at all [NgRest Plugins](ngrest-plugins.md).

> Keep in mind that when a plugin is attached to a field, it will override the original value from the database. Examples are shown in the [Select Plugin Guide](ngrest-plugin-select.md)

#### Scope and ngRestConfig

There are 4 specific Scope you can use to configure. A pointer as like a section of your config:

|Scope Name   |Description
|---       |---
|list      |List the data rows of the Table (like a data table)
|create    |The form to create a new data record.
|update    |Update form to update the value of an existing data record.
|delete    |Define whether items of the data table can be deleted or not. To activate deletion us `$config->delete = true`.
|aw        |[ActiveWindows](ngrest-activewindow.md) Register/add active windows, to this config. Active windows are like buttons you can add to each item record.

As you know what section/Scope you can define with your already defined attributes you have to define the {{luya\admin\ngrest\base\NgRestModel::ngRestConfig}} method, this could look as followed:

```php
public function ngRestScopes()
{
    return [
        ['list',  ['title', 'name', 'timestamp']],
        [['create', 'update'],  ['title', 'name', 'text', 'timestamp', 'description', 'size]],
        ['delete', false],
    ];
}
```

#### Delete

To enable a delete button where the user can remove an item from the database table you can configure the delete pointer:

```php
public function ngRestScopes()
{
    return [
        // ...
        ['delete', false],
    ];
}
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

## Extra Fields

Sometimes you want to define fields which are not part of the ActiveRecord model and are not part of the Database table. For Example you want to display a count of registered users on the curd list. To achieve this goal you may use the `extraFields` principal combined with the yii\base\Object getter/setter informations.

```php
public function getRegisteredCount()
{
    return Users::find()->count();
}

public function extraFields()
{
    return ['registeredCount'];
}
```

Now we have an extraField with the name `registeredCount`. When accessing this extra Field the getter method `getRegisteredCount()` will execute and the number of users will be returned. In order to get this additional into the crud list grid view you have to define the extra field in {{\luya\admin\ngrest\base\NgRestModel::ngrestExtraAttributeTypes}} like the other not extra attribute fields.

```php
public function ngrestExtraAttributeTypes()
{
    return [
        'registeredCount' => 'number',
    ];
}
```

Now the only thing you have to is to add the field to the {{\luya\admin\ngrest\base\NgRestModel::ngRestScopes}} defintion.

```php
public function ngRestScopes($)
{
    return [
        // ...
        ['list', ['registeredCount', '...']] // where ... are the other fields for this scope.
    ];
}
```

## Grid List default Order/Sort

By default the gird list is sorted by the Primary Key (mostly known as ID) in Descending direction. To override the default implement just override the `ngRestListOrder` method with an array where the key is the field and value the direction of sorting.

```php
public function ngRestListOrder()
{
    return ['timestamp_created' => SORT_ASC];
}
```
Now the default ordering of the grid list data is by the field *timestamp_created* in ascending position.

+ `SORT_ASC` = From lower to bigger chars/numbers *1,2,3,..*
+ `SORT_DESC` = From bigger to lower chars/numbers *...,3,2,1*

## Grid List Group Fields

To generate more administration user friendly crud list panels the ability to group fields helps a lot in case of usability. This will automtically group the field values for the defined field and removes the column if the defined group field. To define a default group by policy override the {{\luya\admin\ngrest\base\NgRestModel::ngRestGroupByField}} method like follow, returning a string with the field name where the group should be applied to:

```php
public function ngRestGroupByField()
{
    return 'cat_id';
}
```

The field (`cat_id` in the example) must exist in the list pointer config array.

## Grid List Adding User-Filters

Sometimes the users should filter the crud list data based on different where conditions, assuming we have some calendar data with huge amount of data. Now the administration user should have the possibility to see already past calendar entries, and upcoming calendar entries. To do so we create a new filter for this NgRest Model. To provide filters we have to override the method {{\luya\admin\ngrest\base\NgRestModel::ngRestFilters}} and provide an array with a name and a find statement to collect the data, for example the example described above:

```php
public function ngRestFilters()
{
    return [
        'Upcoming Events' => self::find()->where(['>=', 'timestamp', time()]),
        'Past Events' => self::find()->where(['<=', 'timestamp', time()]),
    ];
}
```

Keep in mind, the query provider [yii\data\ActiveDataProvider](http://www.yiiframework.com/doc-2.0/yii-data-activedataprovider.html) will be used to populate your data, and the expression will be used as `query` Paraementer of the ActiveDataProvider, so now `all()` method needs to be called.


## Override ngRestFind

In order to customize the grid list query to hide (or join) data from the grid list view, you can override the {{\luya\admin\ngrest\base\NgRestModel::ngRestFind}} public static method. This method will be called to retrieve all your data. For example we assume you want to list all news entries which `is_archived` is not 1 (represents an archived news message) than you could override the ngRestFind method as followed:

```php
public static function ngRestFind()
{
    return parent::ngRestFind()->where(['is_archived' => 0]);
}
```

Now only the data where is_archived eqauls 0 will be listed in the crud list overview.

## Update/Create field groups

In order to make your forms better organized and viewable you can group the form fields into groups and collapsed them by default (for example not required fields are then hidden by default but can be access by clicking the group names).

```php
public function ngRestAttributeGroups()
{
   return [
      [['timestamp_create', 'timestamp_display_from', 'timestamp_display_until'], 'Timestamps', 'collapsed' => true],
      [['image_list', 'file_list'], 'Images', 'collapsed' => false],   
   ];
}
```

If collapsed is `true` then the form group is hidden when opening the form, otherwhise its open by default (which is default value when not provided).

## Angular Save/Update callback

Sometimes you just want to trigger some javascript functions after the save/update process in the NgRest Model, therefore you can add config options with wrapped inside a javascript function which will be evaluated in triggered, please take care of javascript errors and eval injections when using this method!

```php

public function ngRestConfig($config)
{
    // ...
    
    $config->options = [
        'saveCallback' => 'function(ServiceMenuData) { ServiceMenuData.load(true); }', // this function callback will be trigger after save/update success calls.
    ];
    
    // ...
    
    return $config;
}
```

## Crud Relation Tabs

Sometimes its usefull and common to directly manage relational data inside the current ngrest crud. Therefore we have created something called {{\luya\admin\ngrest\base\NgRestModel::ngRestRelations}}. Inside this method you can define relations which are also based on the NgRest concept.

```php
public function ngRestRelation()
{
    return [
        ['label' => 'The Label', 'apiEndpoint' => \path\to\ngRest\Model::ngRestApiEndpoint(), 'dataProvider' => $this->getSales()],
    ];
}
```

The above example will use the `getSales()` method of the current model where you are implementing this relation. The `getSales()` must return an {{yii\db\QueryInterface}} Object, for example you can use `$this->hasMany(Model, ['key' => 'rel'])` or `new \yii\db\Query()`.

> Tip: If you generate an NgRest model for a relation which is not used in any other situations you can hide those items from the menu, but not from the permission system. To hide en element add the hiddenInMenu option in the {{\luya\admin\base\Module::getMenu}} method of the module as following: `itemApi('name', 'route', 'icon', 'api', ['hiddenInMenu' => true])`.

## Soft Deletion 

We have also added a soft delete trait {{\luya\admin\traits\SoftDeleteTrait}} which is going to override the default implementation of the `delete` method. When enabled and configure, the soft delete trait will only mark the datarecord to `is_deleted = 1` instead of removing it from the database.

```php
use luya\admin\traits\SoftDeleteTrait;
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

## Scenarios

The rest api uses the `restcreate` and `restupdate` scenarios in order to apply the rules. By default those rules are equals to the `default` rules which is generated by the {{luya\admin\ngrest\base\NgRestModel::scenarios}} method.

If you want to customize the rest scenarios fields as they may differ from the default rule based scenario fields you can override those fields:

```php
public function scenarios()
{
    $scenarios = parent::scenarios();
    $scenarios['restcreate'] = ['firstname', 'lastname', 'create_timestamp'];
    $scenarios['restupdate'] = ['firstname', 'lastname', 'update_timestamp'];
    return $scenarios;
}
```