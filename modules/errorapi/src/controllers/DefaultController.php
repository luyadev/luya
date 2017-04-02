<?php

namespace luya\errorapi\controllers;

use Yii;
use luya\errorapi\models\Data;

/**
 *
 * @todo create phpunit test for module controller actions
 * @author Basil Suter <basil@nadar.io>
 */
class DefaultController extends \luya\rest\Controller
{
    public function userAuthClass()
    {
        return false;
    }

    /**
     * @param $_POST['error_json'] = json_encode(['message' => 'What?', 'serverName' => 'example.com']);
     * @return string
     */
    public function actionCreate()
    {
        $model = new Data();
        $model->error_json = Yii::$app->request->post('error_json', null);
        
        if ($model->save()) {
            if ($this->module->slackToken !== null) {
                $this->slack('#'.$model->identifier.' | '.$model->serverName.': '.$model->message, $this->module->slackChannel);
            }
            
            $mailHtml = $this->renderPartial('_mail', ['model' => $model]);
            
            if (!empty($this->module->recipient)) {
                $mailer = Yii::$app->mail->compose('Error Api: ' . $model->serverName, $mailHtml);
                foreach ($this->module->recipient as $recipient) {
                    $mailer->address($recipient);
                }
                $mailer->send();
            }
            return true;
        }
        
        return $model->getErrors();
    }

    public function slack($message, $room)
    {
        $ch = curl_init('https://slack.com/api/chat.postMessage');
        $data = http_build_query([
            'token' => $this->module->slackToken,
            'channel' => $room,
            'text' => $message,
            'username' => 'Exceptions',
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
