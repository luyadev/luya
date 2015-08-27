<?php

namespace cms\base;

use cmsadmin\models\NavItem;

abstract class Controller extends \luya\base\Controller
{
    /*
     * Use the view files inside the cms module and not within the user project code.
     */
    public $useModuleViewPath = true;

    public function renderItem($navItemId, $appendix = null)
    {
        $model = NavItem::findOne($navItemId);

        $typeModel = $model->getType();
        $typeModel->setOptions([
            'navItemId' => $navItemId,
            'restString' => $appendix,
        ]);

        $content = $typeModel->getContent();

        if ($this->view->title === null) {
            $this->view->title = $model->title;
        }

        return $content;
    }
}
