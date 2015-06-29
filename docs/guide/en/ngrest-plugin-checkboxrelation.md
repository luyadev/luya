Checkbox Releation
=====================

following module configurations are need to create checkbox releation ngrest

```php
class Model extends \luya\admin\ngrest\base\Model
{    
	public $extraFields = ['tags'];
    
	public function scenarios()
	{
        return [
           'restcreate' => ['title', 'text', 'image_id'],
           'restupdate' => ['title', 'text', 'image_id', 'tags'], // add the extraField to the safe attributes
       ];
	}
    
	public $tags = [];

	public function ngRestConfig($config)
	{
		$config->update->extraField("tags", "Tags")->checkboxRelation('\\newsadmin\\models\\Tag', 'news_article_tag', 'article_id', 'tag_id');
	}

}

```

+ `news_article_tag` is the reference table name.
+ `article_id` is the field name in the reference table of the ***current model***.
+ `tag_id` is the field name in the reference table of the ***joining table***.