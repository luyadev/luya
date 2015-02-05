<?php
namespace luya\rest;

class IndexAction extends \yii\rest\IndexAction
{
    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;
        return new \yii\data\ActiveDataProvider([
            'pagination' => false,
            'query' => $modelClass::find(),
        ]);
    }
}