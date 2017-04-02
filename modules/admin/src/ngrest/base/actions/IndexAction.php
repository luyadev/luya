<?php

namespace luya\admin\ngrest\base\actions;

/**
 * IndexAction for REST implementation.
 *
 * In order to enable or disable the pagination for index actions regulatet by the ActiveController
 * the main yii\rest\IndexAction is overriten by adding the pagination propertie to the action
 * provided from the luya\rest\ActiveController.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class IndexAction extends \yii\rest\IndexAction
{
    /**
     * Prepare the data models based on the ngrest find query.
     *
     * {@inheritDoc}
     *
     * @see \yii\rest\IndexAction::prepareDataProvider()
     */
    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;
        $data = new \yii\data\ActiveDataProvider([
            'pagination' => $this->controller->pagination,
            'query' => $modelClass::ngRestFind(),
        ]);

        return $data;
    }
}
