<?php

namespace luya\admin\aws;

use luya\admin\models\Tag;
use luya\admin\models\TagRelation;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Create an Active Window where you can assign tags to a row of the underlying table via a ref table.
 *
 * Use $alias to define the headline in the Active Window
 *
 * Usage example of registering the Tag Active Window:
 *
 * ```php
 * $config->aw->load(['class' => '\luya\admin\aws\TagActiveWindow']);
 * ```
 *
 * If you want to define a specific table name instead of the table name where the active window is attached to use:
 *
 * ```php
 * $config->aw->load(['class' => '\luya\admin\aws\TagActiveWindow', 'tableName' => 'virtualTableName']);
 * ```
 *
 * If you have assigned the {{luya\admin\aws\TagActiveWindow}} aws to an ngrest model you can use the {{luya\admin\traits\TagsTrait}} to access the data.
 *
 * For example when the {{luya\admin\traits\TagsTrait}} is used you can get the data for an active record:
 *
 * ```php
 * $tags = Model::findOne(1)->tags;
 * ```
 *
 * or you can also get all tags assigned for this table:
 *
 * ```php
 * $allTags = Model::findTags();
 * ```
 *
 * @property string $tableName Define a table name if not automaticaly alocated from model.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class TagActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the active windows is located in order to finde the view path.
     */
    public $module = 'admin';
    
    private $_tableName;
    
    /**
     * Getter tableName.
     *
     * @return string
     */
    public function getTableName()
    {
        if ($this->_tableName === null) {
            $this->_tableName = $this->model->tableName();
        }
        
        return $this->_tableName;
    }
    
    /**
     * Setter tableName.
     *
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->_tableName = $tableName;
    }
    
    /**
     * The default action which is going to be requested when clicking the ActiveWindow.
     *
     * @return string The response string, render and displayed trough the angular ajax request.
     */
    public function index()
    {
        return $this->render('index');
    }
    
    /**
     * @inheritdoc
     */
    public function defaultLabel()
    {
        return 'Tags';
    }
    
    /**
     * @inheritdoc
     */
    public function defaultIcon()
    {
        return 'view_list';
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
