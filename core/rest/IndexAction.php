<?php

namespace luya\rest;

/**
 * This class is used to wrap the yii rest indexAction cause of a possibility
 * to overwrite the pagination parameter.
 *
 * @author nadar
 */
class IndexAction extends \yii\rest\IndexAction
{
    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;
        $data = new \yii\data\ActiveDataProvider([
            'pagination' => false,
            'query' => $modelClass::ngRestFind(),
        ]);

        return $data;
    }
}
