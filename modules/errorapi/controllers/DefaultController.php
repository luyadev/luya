<?php

namespace errorapi\controllers;

use Yii;

class DefaultController extends \luya\rest\Controller
{
    public function userAuthClass()
    {
        return false;
    }

    /**
     * @param $_POST['error_json']
     *
     * @return string
     */
    public function actionCreate()
    {
        $model = new \errorapi\models\Data();
        $model->error_json = \yii::$app->request->post('error_json', null);
        if ($model->save()) {
            $this->slack("#" .$model->identifier . ' | ' . $model->serverName . ': ' . $model->msg, '#luya');
            $html = '<table border="1" cellpadding="5" cellspacing="0">';
            foreach(json_decode($model->error_json, true) as $k => $v) {
                $html.='<tr>';
                $html.='<td><strong>'.$k.':</strong></td>';
                $html.='<td>';
                if (is_array($v)) {
                    $html.= "<pre><code>" . print_r($v, true) . "</code></pre>";
                } else {
                    $html.= $v;
                }
                $html.='</td>';
                $html.='</tr>';
            }
            $html.= '</table>';
            Yii::$app->mail->compose('Subject', $html)->address($this->module->recipient)->send();
            return true;
        } else {
            return $model->getErrors();
        }
    }
    
    
    
    public function slack($message, $room) {
        $ch = curl_init("https://slack.com/api/chat.postMessage");
        $data = http_build_query([
        	"token" => $this->module->slackToken,
        	"channel" => $room,
        	"text" => $message,
            "username" => "Exceptions"
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    }

    /**
     * @todo see if the error request have changed based on a bug system.
     */
    public function actionResolve()
    {
    }
}
