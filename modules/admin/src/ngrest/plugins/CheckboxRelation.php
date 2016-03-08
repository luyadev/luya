<?php

namespace admin\ngrest\plugins;

use Yii;

/**
 * @todo check if the plugin is opened by an extraField, cause its not working on casual fields
 *
 * @author nadar
 */
class CheckboxRelation extends \admin\ngrest\base\Plugin
{
    public $model = null;

    public $modelTable = null;

    public $refJoinTable = null;

    public $refModelPkId = null;

    public $refJoinPkId = null;

    public $displayFields = null;

    public $displayTemplate = null;

    /**
     * @param unknown $model           \news\models\Tag::className()
     * @param unknown $refJoinTable    news_article_tag
     * @param unknown $refModelPkId    news_article_tag.arictle_id
     * @param unknown $refJoinPkId     news_article_tag.tag_id
     * @param array   $displayFields
     * @param string  $displayTemplate
     */
    public function __construct($model, $refJoinTable, $refModelPkId, $refJoinPkId, array $displayFields, $displayTemplate = null)
    {
        $this->model = Yii::createObject(['class' => $model]);
        $this->refJoinTable = $refJoinTable;
        $this->refModelPkId = $refModelPkId;
        $this->refJoinPkId = $refJoinPkId;
        $this->displayFields = $displayFields;
        $this->displayTemplate = $displayTemplate;
    }

    private function getOptionsData()
    {
        $items = [];

        $pk = $this->model->primaryKey();
        $pkName = reset($pk);

        $select = $this->displayFields;
        $select[] = $pkName;
        foreach ($this->model->find()->select($select)->all() as $item) {
            $array = $item->getAttributes($select);
            unset($array[$pkName]);
            if ($this->displayTemplate) {
                $label = vsprintf($this->displayTemplate, $array);
            } else {
                $label = implode(', ', $array);
            }
            $items[] = ['value' => $item[$pkName], 'label' => $label];
        }

        return ['items' => $items];
    }

    public function renderList($doc)
    {
        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $this->createBaseElement($doc, 'zaa-checkbox-array');
        $elmn->setAttribute('options', $this->getServiceName('relationdata'));

        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }

    public function serviceData()
    {
        return ['relationdata' => $this->getOptionsData()];
    }

    public function onAfterFind($fieldValue)
    {
        return $this->model->find()->leftJoin($this->refJoinTable, $this->model->tableName().'.id='.$this->refJoinTable.'.'.$this->refJoinPkId)->where([$this->refJoinTable.'.'.$this->refModelPkId => $this->getModel()->id])->all();
    }

    public function onAfterNgRestFind($fieldValue)
    {
        return $this->model->find()->leftJoin($this->refJoinTable, $this->model->tableName().'.id='.$this->refJoinTable.'.'.$this->refJoinPkId)->where([$this->refJoinTable.'.'.$this->refModelPkId => $this->getModel()->id])->all();
    }

    public function onBeforeUpdate($value, $oldValue)
    {
        $this->setRelation($value, $this->refJoinTable, $this->refModelPkId, $this->refJoinPkId);
    }

    public function onAfterCreate($value)
    {
        $this->setRelation($value, $this->refJoinTable, $this->refModelPkId, $this->refJoinPkId);
    }
    
    /**
     * @param array $value          The valued which is provided from the setter method
     * @param string $viaTableName   Example viaTable name: news_article_tag
     * @param string $localTableId   The name of the field inside the viaTable which represents the match against the local table, example: article_id
     * @param string $foreignTableId The name of the field inside the viaTable which represents the match against the foreign table, example: tag_id
     *
     * @return bool
     */
    public function setRelation(array $value, $viaTableName, $localTableId, $foreignTableId)
    {
        Yii::$app->db->createCommand()->delete($viaTableName, [$localTableId => $this->getModel()->id])->execute();
        $batch = [];
        foreach ($value as $k => $v) {
            // $this->id: the value of the current database model, example when relation ins on user model id would be user id
            // $v['id'] extra field values foreached from the join table, so id will represent the joined table pk.

            // issue #696 array logic
            if (is_array($v)) { // its an array and is based on the logic of the angular checkbox releation ['id' => 123]
                $batch[] = [$this->getModel()->id, $v['id']];
            } else { // its not an array so it could have been assigned from the frontend
                $batch[] = [$this->getModel()->id, $v];
            }
        }
        if (!empty($batch)) {
            Yii::$app->db->createCommand()->batchInsert($viaTableName, [$localTableId, $foreignTableId], $batch)->execute();
        }
        // @todo check if an error happends wile the delete and/or update proccess.
        return true;
    }
}
