<?php

namespace admin\ngrest\plugins;

/**
 * @todo check if the plugin is opened by an extraField, cause its not working on casual fields
 *
 * @author nadar
 */
class CheckboxRelation extends \admin\ngrest\base\Plugin
{
    use \admin\ngrest\PluginTrait;

    public $model = null;

    public $modelTable = null;

    public $refJoinTable = null;

    public $refModelPkId = null;

    public $refJoinPkId = null;
    /**
     * @param unknown $model        \news\models\Tag::className()
     * @param unknown $refJoinTable news_article_tag
     * @param unknown $refModelPkId news_article_tag.arictle_id
     * @param unknown $refJoinPkId  news_article_tag.tag_id
     */
    public function __construct($model, $refJoinTable, $refModelPkId, $refJoinPkId)
    {
        $this->model = new $model();
        $this->refJoinTable = $refJoinTable;
        $this->refModelPkId = $refModelPkId;
        $this->refJoinPkId = $refJoinPkId;
    }

    /*
    public $options = [
        "model" => "",
        "joinModel" => "",
        ""
    ];
    */
    public function renderCreate($doc)
    {
        $items = [];
        foreach ($this->model->find()->all() as $item) {
            $items[] = ['id' => $item->id, 'label' => implode(' | ', $item->toArray())];
        }

        $elmn = $doc->createElement('zaa-checkbox', '');
        $elmn->setAttribute('id', $this->id);
        $elmn->setIdAttribute('id', true);
        $elmn->setAttribute('model', $this->ngModel);
        $elmn->setAttribute('options', json_encode(['items' => $items]));
        $elmn->setAttribute('label', $this->alias);
        $elmn->setAttribute('grid', $this->gridCols);
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }

    //

    public function onAfterList($value)
    {
        return $this->model->find()->leftJoin($this->refJoinTable, $this->model->tableName().'.id='.$this->refJoinTable.'.'.$this->refJoinPkId)->where($this->refJoinTable.'.'.$this->refModelPkId.'='.$this->getModel()->id)->all();
    }

    public function onBeforeUpdate($value, $oldValue)
    {
        $this->getModel()->setRelation($value, $this->refJoinTable, $this->refModelPkId, $this->refJoinPkId);
    }

    public function onAfterCreate($value)
    {
        $this->getModel()->setRelation($value, $this->refJoinTable, $this->refModelPkId, $this->refJoinPkId);
    }
}
