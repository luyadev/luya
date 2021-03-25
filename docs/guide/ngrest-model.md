# NgRest Model

The {{luya\admin\ngrest\base\NgRestModel}} is the base class for the API. It is implementing the {{yii\db\ActiveRecord}} class in order to find, update, create and delete database table data.

> You should read the [[ngrest-concept.md]] in order to understand what the NgRest model is all about.

## Where do I configure it?

Each NgRest model does have a {{luya\admin\ngrest\base\NgRestModel::ngrestAttributeTypes()}} method where you can define which type of fields you have and {{luya\admin\ngrest\base\NgRestModel::ngRestConfig()}} where you can define the fields for the specific scope (crud, list, create).

#### Define attribute types

To define an attribute type for a specific attribute you have to override the {{luya\admin\ngrest\base\NgRestModel::ngrestAttributeTypes()}} method by returning an array where the key is the field and value the config of the [NgRest Plugin](ngrest-plugins.md).

An example of a definitions:

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

A definition contains always the attribute (as key) and the NgRest plugin config. If you have to pass arguments to the plugin object you can define an array where the first key is the name of the plugin and the other keys are the plugin properties. Take a look at all [NgRest Plugins](ngrest-plugins.md).

> Keep in mind that when a plugin is attached to a field, it will override the original value from the database. Examples are shown in the [Select Plugin Guide](ngrest-plugin-select.md)

#### Scope and NgRest config

There are different scope pointers you can configure in order to tell your forms and list which fields should be displayed.

|Scope Name   |Description
|---       |---
|list      |List all table rows with the given columns.
|create    |Forms to create a new record with the given columns.
|update    |Forms to update an existing record with the given columns.
|delete    |Define whether items of the data table can be deleted or not. To activate deletion set this pointer to `true`.
|aw        |Attach a [[ngrest-activewindow.md]] to each row in the list overview, e.g. a button next to edit button.

As you know what section/scope you can define with your already defined attributes you have to define the {{luya\admin\ngrest\base\NgRestModel::ngRestConfig()}} method, this could look as followed:

```php
public function ngRestScopes()
{
    return [
        ['list',  ['title', 'name', 'timestamp']],
        [['create', 'update'],  ['title', 'name', 'text', 'timestamp', 'description', 'size']],
        ['delete', false],
    ];
}
```

The primary key column will be auto added to the list scope, in order to hide the ID column set {{luya\admin\ngrest\base\Plugin::$hideInList}} but add the attribute to the list scope:

```php
public function ngRestAttributeTypes()
{
    return [
        'id' => ['number', 'hideInList' => true],
    ];
}
```

Add to the list of attributes:

```php
public function ngRestScopes()
{
    return [
        ['list', ['id', /* ... */ ]],
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
``` 

This will trigger the {{luya\admin\ngrest\base\NgRestModel::delete()}} method and will irrevocable remove the given record. You can override the {{luya\admin\ngrest\base\NgRestModel::delete()}} method to change the behavior of a deletion or using {{luya\admin\traits\SoftDeleteTrait}}.

## Multlingual / i18n fields

You can define all fields as multi lingual by the following setting:

```php
public $i18n = ['title', 'description'];
```

This will automatically enable the options to add content for all languages to each field and returns the content for the current active language when returning the data from the model in the frontend.

When casting a field as i18n it will save the multi lingual data in json format in the database.

> All i18n fields must be type of varchar or text in the database as it is json encodes the input array in the database table field.

The i18n fields will be saved as JSON with a string entry for every CMS language. If you access a field, the value for the current CMS language will be automatically extracted. To access the i18n fields as JSON without the automatic conversion, use `$this->getOldAttribute('FIELDNAME')`. This is helpful when manually wanting to check/validate the entries for every language.

## Extra fields

Sometimes you want to define fields which are not part of the ActiveRecord model and are not part of the database table, e. g. you want to display a count of registered users on the CRUD list. To achieve this you may use the `extraFields` principal combined with the {{yii\base\BaseObject}} getter/setter information.

Extra fields require:

+ A getter method. `getRegisteredCount()`
+ A defintion entry in {{\luya\admin\ngrest\base\NgRestModel::ngRestExtraAttributeTypes()}}. `'registeredCount' => 'number'`
+ A validation rule assigned to the attribute name using {{\luya\admin\ngrest\base\NgRestModel::rules()}}.  `['registeredCount', 'safe']`

```php
public function getRegisteredCount()
{
    return Users::find()->count();
}
```

Now we have an extraField with the name `registeredCount`. When accessing this extra field the getter method `getRegisteredCount()` will execute and the number of users will be returned. In order to get this additional into the CRUD list grid view you have to define the extra field in {{\luya\admin\ngrest\base\NgRestModel::ngRestExtraAttributeTypes()}} like the other not extra attribute fields.

```php
public function ngRestExtraAttributeTypes()
{
    return [
        'registeredCount' => 'number',
    ];
}
```

> The `ngRestExtraAttributeTypes()` defined attributes will be automatically added to {{luya\luya\admin\ngrest\base\NgRestModel::extraFields()}}.

In order to work with this new defined extraibue pass the extra to the {{\luya\admin\ngrest\base\NgRestModel::ngRestScopes()}} definition.

```php
public function ngRestScopes($)
{
    return [
        // ...
        ['list', ['registeredCount', '...']] // where ... are the other fields for this scope.
    ];
}
```

Its also required to add a validation rule using {{\luya\admin\ngrest\base\NgRestModel::rules()}} for the given attribute, as all attributes defined in {{\luya\admin\ngrest\base\NgRestModel::ngRestScopes()}} will be looked up in the list of {{\luya\admin\ngrest\base\NgRestModel::rules()}}.

#### Extra Attribute without Value

In certain siutation the extra field is not bound to any data, therefore you can either override the extraFields() method and remove the custom attribute or you can attach the "virtual" attribute to an existing root attribute using `.` notation:

```php
public function ngRestExtraAttributeTypes()
{
     return [
        'id.indexField' => ['index'],
    ];
}
```

This will use the root attribute id which is present in the view, this can be usefull when using {{luya\admin\ngrest\plugins\Angular}} plugins.

## Default Order (Sorting)

By default the gird list is sorted by the primary key (mostly known as ID) in descending direction. To override the default implement just override the `ngRestListOrder` method with an array where the key is the field and value the direction of sorting.

```php
public function ngRestListOrder()
{
    return ['timestamp_created' => SORT_ASC];
}
```
Now the default ordering of the grid list data is by the field *timestamp_created* in ascending position.

+ `SORT_ASC` = From lower to bigger chars/numbers *1,2,3,..*
+ `SORT_DESC` = From bigger to lower chars/numbers *...,3,2,1*

> In order allow sorting for joined fields (using SelectModel f.e.) take a look at {{luya\admin\ngrest\base\Plugin::setSortField()}}

## Group by Field Value

To generate more user friendly CRUD list panels the ability to group fields helps a lot in case of usability. This will automatically group the field values for the defined field and removes the column if the defined group field. To define a default group by policy override the {{\luya\admin\ngrest\base\NgRestModel::ngRestGroupByField()}} method by returning a string with the field name where the group should be applied to:

```php
public function ngRestGroupByField()
{
    return 'cat_id';
}
```

The field (e. g. `cat_id`) must exist in the list pointer config array.

## Grid list adding user filters

Sometimes the users should be able to filter the CRUD list data based on different `where conditions. Let´s assume we have some calendar data with huge amount of data. Now the admin UI user should have the possibility to see already past calendar entries and upcoming calendar entries. To do so we create a new filter for this NgRest model. To provide filters we have to override the method {{\luya\admin\ngrest\base\NgRestModel::ngRestFilters()}} and provide an array with a name and a find statement to collect the data, e.g. based on the example described above:

```php
public function ngRestFilters()
{
    return [
        'Upcoming Events' => self::find()->where(['>=', 'timestamp', time()]),
        'Past Events' => self::find()->where(['<=', 'timestamp', time()]),
    ];
}
```

Keep in mind the query provider [yii\data\ActiveDataProvider](http://www.yiiframework.com/doc-2.0/yii-data-activedataprovider.html) will be used to populate your data and the expression will be used as `query` parameter of the ActiveDataProvider which means now the `all()` method needs to be called.


## Override ngRestFind

In order to customize the grid list query to hide (or join) data from the grid list view you can override the {{\luya\admin\ngrest\base\NgRestModel::ngRestFind()}} public static method. This method will be called to retrieve all your data, e.g. we want to list all news entries which have the status `is_archived` and not 1 (represents an archived news message) than you could override the ngRestFind method as followed:

```php
public static function ngRestFind()
{
    return parent::ngRestFind()->where(['is_archived' => 0]);
}
```

Now only the data where is_archived equals 0 will be listed in the crud list overview.

## Update/Create field groups

In order to make your forms better organized and viewable you can group the form fields into groups and collapsed them by default (e.g. not required fields could be hidden by default but can be accessed by clicking the group names).

```php
public function ngRestAttributeGroups()
{
   return [
      [['timestamp_create', 'timestamp_display_from', 'timestamp_display_until'], 'Timestamps', 'collapsed' => true],
      [['image_list', 'file_list'], 'Images', 'collapsed' => false],   
   ];
}
```

If collapsed is `true` then the form group is hidden when opening the form, otherwise it is open by default (which is default value when nothing else is provided).

## Angular Save/Update callback

Sometimes you just want to trigger some javascript functions after the save/update process in the NgRest model, therefore you can add config options with wrapped inside a javascript function which will be evaluated in triggered, please take care of javascript errors and eval injections when using this method!

```php
public function ngRestConfigOptions()
{
    return [
        'saveCallback' => "['ServiceMenuData', function(ServiceMenuData) { ServiceMenuData.load(true); }]",
    ];
}
```

When using an angular service injection, make sure to use strict di which is required since luya admin module version 1.2.

## Crud Relation Tabs

Sometimes it is useful and common to directly manage relational data inside the current ngrest crud. Therefore we have created something called {{\luya\admin\ngrest\base\NgRestModel::ngRestRelations()}}. Inside this method you can define relations which are also based on the NgRest concept.

```php
public function ngRestRelations()
{
    return [
        ['label' => 'Label', 'targetModel' => \path\to\Model::class, 'dataProvider' => $this->getSales()],
    ];
}
```

Where `getSales()` would be:

```php
public function getSales()
{
    return $this->hasMany(Sales::class, ['id' => 'sale_id']);
}
``` 

Take a look at {{luya\admin\ngrest\base\NgRestRelation}} for the full object configuration properties.


The above example will use the `getSales()` method of the current model where you are implementing this relation. The `getSales()` must return an {{yii\db\QueryInterface}} Object, for example you can use `$this->hasMany(Model, ['key' => 'rel'])` or `new \yii\db\Query()`.

> Tip: If you generate an NgRest model for a relation which is not used in any other situations you can hide those items from the menu, but not from the permission system. To hide en element add the hiddenInMenu option in the {{\luya\admin\base\Module::getMenu()}} method of the module as following: `itemApi('name', 'route', 'icon', 'api', ['hiddenInMenu' => true])`.

If you like to display the name of the current element in the tabe you can define `'tabLabelAttribute' => 'fieldName'` where fieldName is the name of the attribute in the list overview.

## Soft Deletion 

We have also added a soft delete trait {{\luya\admin\traits\SoftDeleteTrait}} which is going to override the default implementation of the `delete` method. When enabled and configure, the soft delete trait will only mark the datarecord to `is_deleted = 1` instead of removing it from the database.

```php
use luya\admin\traits\SoftDeleteTrait;
```

By default, soft delete trait will use the field `is_deleted` to find and delete data records, you can configure the field by overriding the {{luya\admin\traits\SoftDeleteTrait::fieldStateDescriber()}} method as followed:

```php
public static function fieldStateDescriber()
{
    return [
        'is_deleted' => [1, 0], // on delete sets `is_deleted = 1`; on find add where `where(['is_deleted' => 0]);`.
        'is_inactive' => true, // on delete sets `is_inactive = true`; on find add where `where(['is_inactive' => !true]);`.
    ]
}
```

## Scenarios

The rest api uses the `restcreate` and `restupdate` scenarios in order to apply the rules. By default those rules are equals to the `default` rules which is generated by the {{luya\admin\ngrest\base\NgRestModel::scenarios()}} method.

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

## Button conditions

In order to show/hide the update and delete buttons, you can define a `buttonCondition` along with the scope parameters Example:

```php
public function ngRestScopes()
{
    return [
        ['list', ['title', 'firstname', 'lastname', 'email']],
        ['create', ['title', 'firstname', 'lastname', 'email', 'password']],
        ['update', ['title', 'firstname', 'lastname', 'email'], ['buttonCondition'=> '{title}>1']],
        ['delete', true, ['buttonCondition'=> ['{title}'=>2, '{firstname}'=>'\'bar\'']] ],
    ];
}
```

A conditin like `['{title}'=>2, '{firstname}'=>'\'bar\'']]` will be evaluted as ng-show="item.title==2 && item.firstname=='bar'"

The button conditions might also be defined separtly in the `ngRestConfigOptions()` function e.g. :

```php
public function ngRestConfigOptions()
{
    return [
        'buttonCondition' => [
            [ 'update', '{title}==1'],
            [ 'delete', '{title}==2'],
        ],
   ];
}
```
