<?php

namespace luya\admin\components;

use yii;

/**
 * Url rule for NgRest Apis
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class UrlRule extends \yii\rest\UrlRule
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $map = Yii::$app->getModule('admin')->controllerMap;

        if (count($map) > 0) {
            foreach ($map as $alias => $className) {
                $class = sprintf('%s/%s', 'admin', $alias);
                $this->controller[] = $class;
            }

            parent::init();
        } else {
            $this->controller = [];
        }
    }
    
    public $pluralize = false;
}
