Checkbox Releation
=====================

following module configurations are need to create checkbox releation ngrest

```php

class Model extends \luya\admin\ngrest\base\Model
{
	    
    public $extraFields = ['tags'];
    
    public function setTags($value)
    {
        $this->proccess($value, "news_article_tag", "article_id", "tag_id");
    }
    
    public function getTags()
    {
        return $this->hasMany(\newsadmin\models\Tag::className(), ['id' => 'tag_id'])->viaTable('news_article_tag', ['article_id' => 'id']);
    }

	public function ngRestConfig($config)
	{
		...
		
		$config->update->extraField("tags", "Tags")->checkboxReleation(['model' => \newsadmin\models\Tag::className(), 'labelField' => 'title']);
		
		...
	}

}


```