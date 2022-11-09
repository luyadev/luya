<?php

namespace luya\tag;

use Yii;
use yii\base\BaseObject;

/**
 * The BaseTag for all Tags.
 *
 * @property \luya\web\View $view The view object in order to register scripts.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class BaseTag extends BaseObject implements TagInterface
{
    private $_view;

    /**
     * Get the view object to register assets in tags.
     *
     * @return \luya\web\View
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = Yii::$app->getView();
        }

        return $this->_view;
    }
}
