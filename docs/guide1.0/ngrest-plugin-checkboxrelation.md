Checkbox Releation
=====================

following module configurations are need to create checkbox releation ngrest

```php
class Model extends \admin\ngrest\base\Model
{    

    public $groups = [];
    
    public $extraFields = ['groups'];
    
	public function scenarios()
	{
        return [
           'restcreate' => ['title', 'text', 'image_id', 'groups],
           'restupdate' => ['title', 'text', 'image_id', 'groups'], // add the extraField to the safe attributes
       ];
	}
    
	public $tags = [];

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