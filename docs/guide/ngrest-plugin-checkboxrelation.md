# Checkbox relations

Ability to make an checkbox input where you can select items from another table connected with a via/ref Table.

+ Create public property (in order to communicate with the api) f.e. `$adminGroups`
+ Register the attribute type in the `ngrestExtraAttributeTypes()` method.

## Active query relation

The {{luya\admin\ngrest\plugins\CheckboxRelationActiveQuery}} plugin is the recommend way to work with via/junction tables or in other words, make a checkbox relation based on an active query relation definition inside your model:

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
             [['create', 'update'], ['adminGroups']],
        ];
    }
}
```

The difference is mainly to use a variable which is used to store and get data for plugin prefix with `admin` in the above example its `$adminGroups`.

## No relation definition

The {{luya\admin\ngrest\plugins\CheckboxRelation}} plugin is the quick and raw solution when working without relation definitions is needed.

Below, an example of a user model where you can select the related groups and stored in a via/ref table named `admin_user_group`:

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
                'class' => CheckboxRelation::class,
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
