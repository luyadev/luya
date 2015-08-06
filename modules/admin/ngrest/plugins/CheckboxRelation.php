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
    
    public $displayFields = null;
    
    public $displayTemplate = null;
    
    /**
     * @param unknown $model        \news\models\Tag::className()
     * @param unknown $refJoinTable news_article_tag
     * @param unknown $refModelPkId news_article_tag.arictle_id
     * @param unknown $refJoinPkId  news_article_tag.tag_id
     */
    public function __construct($model, $refJoinTable, $refModelPkId, $refJoinPkId, array $displayFields, $displayTemplate = null)
    {
        $this->model = new $model();
        $this->refJoinTable = $refJoinTable;
        $this->refModelPkId = $refModelPkId;
        $this->refJoinPkId = $refJoinPkId;
        $this->displayFields = $displayFields;
        $this->displayTemplate = $displayTemplate;
    }

    private function getOptionsData()
    {
        $items = [];
        foreach ($this->model->find()->select($this->displayFields)->all() as $item) {
            if ($this->displayTemplate) {
                $label = vsprintf($this->displayTemplate, $item->toArray());
            } else {
                $label = implode(', ', $item->toArray());
            }
            $items[] = ['id' => $item->id, 'label' => $label];
        }
        
        return ['items' => $items];
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
        
        $elmn = $this->createBaseElement($doc, 'zaa-checkbox-array');
        $elmn->setAttribute('options', $this->getServiceName('relationdata'));
        
        $doc->appendChild($elmn);

        return $doc;
    }
    
    public function serviceData()
    {
        return ['relationdata' => $this->getOptionsData()];
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }

    //

    public function onAfterFind($value)
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
