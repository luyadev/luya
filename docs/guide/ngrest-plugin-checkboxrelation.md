# Checkbox Releations

Ability to make an checkbox input where you can select items from another table connect with a via/ref Table.

+ Create public propertie (in order to communicate with the api) `$groups`
+ Add the extra field to the safe attributes.
+ Register the attribute type in the `ngrestExtraAttributeTypes()` method.

## Active Query Relation

The {{luya\admin\ngrest\plugins\CheckboxRelationActiveQuery}} plugin the recommend way to work with via/junction tables. Make checkboxRelation based on an Active Query Relation definition inside your model:

```php
class User extends \luya\admin\ngrest\base\NgRestModel
{
    public $adminGroups = [];
    
    public function rules()
    {
        return [
            // ...
            [['adminGroups'], 'safe'],
        ];
    }
    
    public function getGroups()
    {
        return $this->hasMany(Group::class, ['id' => 'group_id'])->viaTable('admin_user_group', ['user_id' => 'id']);
    }
    
    public function ngRestExtraAttributeTypes()
    {
        return [
            'adminGroups' => [
                'class' => CheckboxRelationActiveQuery::class,
                'query' => $this->getGroups(),
                'labelField' => ['name'],
            ],
       ];
    }
    
    public function ngRestScopes($config)
    {
        return [
             // ...
             [['create', 'update'], ['adminGroups']],
        ];
    }
}
```

The difference is mainly to use a variable which is used to store and get data for plugin prefix with `admin`.

## No Relation defintion

The {{luya\admin\ngrest\plugins\CheckboxRelation}} plugin is the quick and drity solution when not working relation defintions.

Below an example of a User model where you can select the related Groups and stored in a via/ref table named `admin_user_group`:

```php
class User extends \luya\admin\ngrest\base\NgRestModel
{    
    public $groups = [];

    public function rules()
    {
        return [
            // ...
            [['groups'], 'safe'],
        ];
    }

    public function ngrestExtraAttributeTypes()
    {
        return [
            'groups' => [
                'checkboxRelation',
                'model' => Group::className(),
                'refJoinTable' => 'admin_user_group',
                'refModelPkId' => 'group_id',
                'refJoinPkId' => 'user_id',
                'labelField' => ['firstname', 'lastname', 'email'],
                'labelTemplate' =>  '%s %s (%s)'
            ],
        ];
    }

    public function ngRestScopes($config)
    {
        return [
             // ...
             [['create', 'update'], ['groups']],
        ];
    }
}
```