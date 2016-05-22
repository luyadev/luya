<?php

namespace admin\controllers;

use Yii;
use admin\ngrest\NgRest;
use yii\web\Response;
use luya\Exception;
use luya\helpers\FileHelper;

class NgrestController extends \admin\base\Controller
{
    public $disablePermissionCheck = true;
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => 'yii\filters\ContentNegotiator',
            'only' => ['callback'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ];
        return $behaviors;
    }

    public function actionRender()
    {
        $config = NgRest::findConfig(Yii::$app->request->post('ngrestConfigHash', false));

        $render = new \admin\ngrest\render\RenderActiveWindow();

        $render->setItemId(Yii::$app->request->post('itemId', false));
        $render->setActiveWindowHash(Yii::$app->request->post('activeWindowHash', false));

        $ngrest = new NgRest($config);

        return $ngrest->render($render);
    }

    public function actionCallback()
    {
        $config = NgRest::findConfig(Yii::$app->request->get('ngrestConfigHash', false));

        $render = new \admin\ngrest\render\RenderActiveWindowCallback();

        $ngrest = new NgRest($config);

        return $ngrest->render($render);
    }
    
    public function actionExportDownload($key)
    {
    	$sessionkey = Yii::$app->session->get('tempNgRestKey');
    	
    	if ($sessionkey !== base64_decode($key)) {
    		throw new Exception('Invalid Export download key.');
    	}
    	
    	$content = FileHelper::getFileContent('@runtime/'.$sessionkey.'.tmp');
    	
    	Yii::$app->session->remove('tempNgRestKey');
    	
    	return Yii::$app->response->sendContentAsFile($content, 'filedownload.csv');
    }
}
