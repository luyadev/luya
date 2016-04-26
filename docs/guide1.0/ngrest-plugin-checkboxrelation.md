# Checkbox Releation Plugin

The checkbox releation quickly adds the ability to make an checkbox input where you can select items from another table connect with a via/ref Table. In order to register a checkbox plugin to your module you have to do the special steps:

+ Create public propertie (in order to communicate with the api) `$groups`
+ Define the attribute in the `$extraFields` array.
+ Register the attribute type in the `ngrestExtraAttributeTypes()` method.

Below an example of a User model where you can select the related Groups and stored in a via/ref table named `admin_user_group`:

```php
class User extends \admin\ngrest\base\Model
{    

    public $groups = [];
    
    public $extraFields = ['groups']; // define the extra field
    
	public function scenarios()
	{
        return [
           'restcreate' => ['title', 'text', 'image_id', 'groups'], // add the extraField to the safe attributes
           'restupdate' => ['title', 'text', 'image_id', 'groups'], // add the extraField to the safe attributes
        ];
    }
    
    public function ngrestExtraAttributeTypes()
    {
        return [
            'groups' => [
                'checkboxRelation',
                'model' => User::className(),
                'refJoinTable' => 'admin_user_group',
                'refModelPkId' => 'group_id',
                'refJoinPkId' => 'user_id',
                'labelFields' => ['firstname', 'lastname', 'email'],
                'labelTemplate' =>  '%s %s (%s)'
            ],
        ];
    }

	public function ngRestConfig($config)
	{
	    // ...
		$this->ngRestConfigDefine($config, ['create', 'update'], ['groups']);
		// ...
	}

}
```