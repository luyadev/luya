<?php

namespace luya\traits;

use Yii;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use Curl\Curl;

/**
 * ErrorHandler trait to extend the renderException method with an api call if enabled.
 * 
 * @author nadar
 */
trait ErrorHandler
{
    /**
     * @var string The url where the errorapi module has been added
     */
    public $api = 'http://luya.io/errorapi';

    /**
     * @var boolean Enable the transfer of exception informations
     */
    public $transferException = false;

    /**
     * {@inheritdoc}
     */
    public function renderException($exception)
    {
        if ($exception instanceof NotFoundHttpException || !$this->transferException) {
            return parent::renderException($exception);
        }
        
        $curl = new Curl();
        $response = $curl->post(rtrim($this->api, '/').'/create', [
            'error_json' => Json::encode($this->getExceptionArray($exception)),
        ]);
        
        return parent::renderException($exception);
    }

    /**
     * Get an readable array to transfer from an exception
     * 
     * @todo: catch getPrevious() exception.
     * @param mixed $exception Exception object
     * @return array An array with transformed exception data
     */
    public function getExceptionArray($exception)
    {
        $_trace = [];
        $_message = 'Uknonwn exception object, not instance of \Exception.';
        $_file = 'unknown';
        $_line = 0;
        
        if ($exception instanceof \Exception) {
            foreach ($exception->getTrace() as $key => $item) {
                $_trace[$key] = [
                    'file' => isset($item['file']) ? $item['file'] : null,
                    'line' => isset($item['line']) ? $item['line'] : null,
                    'function' => isset($item['function']) ? $item['function'] : null,
                    'class' => isset($item['class']) ? $item['class'] : null,
                ];
            }
            $_message = $exception->getMessage();
            $_file = $exception->getFile();
            $_line = $exception->getLine();
        } elseif (is_string($exception)) {
            $_message = 'exception string: ' . $exception;
        } elseif (is_array($exception)) {
            $_message = 'exception array dump: ' . print_r($exception, true);
        }

        return [
            'message' => $_message,
            'file' => $_file,
            'line' => $_line,
            'requestUri' => (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : null,
            'serverName' => (isset($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : null,
            'date' => date('d.m.Y H:i'),
            'trace' => $_trace,
            'ip' => (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : null,
            'get' => Yii::$app->request->get(),
            'post' => Yii::$app->request->post(),
        ];
    }
}
