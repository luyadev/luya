<?php

namespace contactform\controllers;

use Yii;
use luya\base\DynamicModel;
use yii\base\InvalidConfigException;

class DefaultController extends \luya\web\Controller
{
    public function actionIndex()
    {
        $model = new DynamicModel($this->module->attributes);
        $model->attributeLabels = $this->module->attributeLabels;
        $sucess = false;
        
        foreach ($this->module->rules as $rule) {
            if (is_array($rule) && isset($rule[0], $rule[1])) {
                $model->addRule($rule[0], $rule[1], isset($rule[2]) ? $rule[2] : []);
            } else {
                throw new InvalidConfigException('Invalid calidation rule: a rule must specify both attribute names and validator type.');
            }
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $html = '<h1>Contact Form '.Yii::$app->siteTitle.'</h1><p>Submission Date: '.date("d.m.Y H:i").'</p><table border="1">';
            foreach($model->getAttributes() as $key => $value) {
                $html.='<tr><td>'.$model->getAttributeLabel($key).'</td><td>' . nl2br($value) . '</td>';
            }
            $html.= '</table>';
            
            $mail = Yii::$app->mail->compose('['.Yii::$app->siteTitle.'] contact form', $html);
            $mail->adresses($this->module->recipients);
            
            if ($mail->send()) {
                $sucess = true;
                Yii::$app->session->setFlash('contactform_success');
            }
        }
        
        return $this->render('index', [
            'model' => $model,
            'success' => $sucess,
        ]);
    }
}