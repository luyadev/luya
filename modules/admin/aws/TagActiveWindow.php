<?php

namespace admin\aws;

use admin\models\Tag;
use admin\models\TagRelation;

class TagActiveWindow extends \admin\ngrest\base\ActiveWindow
{
    public $module = 'admin';

    public $tableName = null;

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
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
        } else {
            $model = new TagRelation();
            $model->setAttributes([
                'tag_id' => $tagId,
                'table_name' => $this->tableName,
                'pk_id' => $this->getItemId(),
            ]);
            $model->insert(false);
        }

        return true;
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
