<?php

namespace admin\aws;

use luya\Exception;
use admin\models\Tag;
use admin\models\TagRelation;

/**
 * Create an Active Window where you can assign tags to a row of the underlying table via a ref table.
 *
 * Use $alias to define the headline in the Active Window
 *
 * Usage example of registering the Tag Active Window:
 *
 * ```php
 * $config->aw->load(['class' => '\admin\aws\TagActiveWindow', 'alias' => 'Tags', 'tableName' => self::tableName()]);
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class TagActiveWindow extends \admin\ngrest\base\ActiveWindow
{
    public $module = 'admin';

    public $icon = "view_list";

    public $tableName = null;

    public function init()
    {
        parent::init();
        
        if ($this->tableName === null) {
            throw new Exception("The Active Window tableName property can not be null.");
        }
    }
    
    public function index()
    {
        return $this->render('index');
    }

    public function callbackLoadTags()
    {
        return Tag::find()->asArray()->all();
    }

    public function callbackLoadRelations()
    {
        return TagRelation::find()->where(['table_name' => $this->tableName, 'pk_id' => $this->getItemId()])->asArray()->all();
    }

    public function callbackSaveRelation($tagId, $value)
    {
        $find = TagRelation::find()->where(['tag_id' => $tagId, 'table_name' => $this->tableName, 'pk_id' => $this->getItemId()])->one();

        if ($find) {
            TagRelation::deleteAll(['tag_id' => $tagId, 'table_name' => $this->tableName, 'pk_id' => $this->getItemId()]);
            return 0;
        } else {
            $model = new TagRelation();
            $model->setAttributes([
                'tag_id' => $tagId,
                'table_name' => $this->tableName,
                'pk_id' => $this->getItemId(),
            ]);
            $model->insert(false);
            return 1;
        }
    }

    public function callbackSaveTag($tagName)
    {
        $model = Tag::find()->where(['name' => $tagName])->one();

        if ($model) {
            return false;
        }

        $model = new Tag();
        $model->scenario = 'restcreate';
        $model->setAttributes(['name' => $tagName]);
        $model->save(false);

        return $model->id;
    }
}
