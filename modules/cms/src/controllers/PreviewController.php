<?php

namespace cms\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use cmsadmin\models\NavItem;
use cms\menu\InjectItem;

/**
 * CMS Preview Rendering
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class PreviewController extends \cms\base\Controller
{
    public function actionIndex($itemId)
    {
        if (Yii::$app->adminuser->isGuest) {
            throw new ForbiddenHttpException('Unable to see the preview page, session expired or not logged in.');
        }

        $navItem = NavItem::findOne($itemId);
        $langShortCode = $navItem->lang->short_code;

        Yii::$app->composition['langShortCode'] = $langShortCode;

        $item = Yii::$app->menu->find()->where(['id' => $itemId])->with('hidden')->lang($langShortCode)->one();

        // this item is still offline so we have to inject and fake it with the inject api
        if (!$item) {
        	// create new item to inject
        	$inject = new InjectItem([
        		'childOf' => Yii::$app->menu->home->id,
        		'title' => $navItem->title,
        		'alias' => $navItem->alias,
        		'isHidden' => true,
        	]);
        	// inject item into menu component
        	Yii::$app->menu->injectItem($inject);
        	// find the inject menu item
        	$item = Yii::$app->menu->find()->where(['id' => $inject->id])->with('hidden')->lang($langShortCode)->one();
        	// something really went wrong while finding injected item
        	if (!$item) {
        		throw new NotFoundHttpException("Unable to find the preview for this ID, maybe the page is still Offline?");
        	}
        }

        // set the current item, as it would be resolved wrong from the url manager / request path
        Yii::$app->menu->current = $item;
        
        return $this->render('index', [
            'pageContent' => $this->renderItem($itemId),
        ]);
    }
}
