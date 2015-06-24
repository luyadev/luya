<?php

namespace cms\base;

use Yii;
use \cmsadmin\models\NavItem;

abstract class Controller extends \luya\base\PageController
{
    /*
     * Use the view files inside the cms module and not within the user project code.
     */
    public $useModuleViewPath = true;

    public function renderItem($navItemId, $appendix = null)
    {
        $model = NavItem::findOne($navItemId);
        $this->pageTitle = $model->title;
        $typeModel = $model->getType();
        $typeModel->setOptions([
            'navItemId' => $navItemId,
            'restString' => $appendix,
        ]);
        $content = $typeModel->getContent();
        foreach($typeModel->getContextPropertysArray() as $prop => $value) {
            if (!empty($value)) {
                $this->$prop = $value;
            }
        }
        return $content;
    }
}
