<?php

namespace luya\errorapi\controllers;

use Yii;
use luya\errorapi\models\Data;

/**
 * Default Controller for the Error API.
 *
 * The `create` action is used in order to recieve error reports from a given website.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class DefaultController extends \luya\rest\Controller
{
    /**
     * @inheritdoc
     */
    public function userAuthClass()
    {
        return false;
    }

    /**
     * Create a new error report.
     *
     * In order to create new error report send a post request with the key `error_json` containing a json.
     *
     * Example:
     *
     * ```php
     * $_POST['error_json'] = json_encode(['message' => 'What?', 'serverName' => 'example.com']);
     * ```
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

    /**
     * Send a message to given slack channel.
     *
     * @param string $message The message to be sent.
     * @param string $channel The channel where the message should appear.
     * @return mixed
     */
    public function slack($message, $channel)
    {
        $ch = curl_init('https://slack.com/api/chat.postMessage');
        $data = http_build_query([
            'token' => $this->module->slackToken,
            'channel' => $channel,
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
}
