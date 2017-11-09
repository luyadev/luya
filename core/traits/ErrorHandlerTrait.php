<?php

namespace luya\traits;

use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use Curl\Curl;
use luya\helpers\Url;

/**
 * ErrorHandler trait to extend the renderException method with an api call if enabled.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
trait ErrorHandlerTrait
{
    /**
     * @var string The url of the error api without trailing slash. Make sure you have installed the error api
     * module on the requested api url (https://luya.io/guide/module/luyadev---luya-module-errorapi).
     * 
     * An example when using the erroapi module, the url could look like this `https://luya.io/errorapi`.
     */
    public $api;

    /**
     * @var boolean Enable the transfer of exceptions to the defined `$api` server.
     */
    public $transferException = false;

    /**
     * Send a custom message to the api server event its not related to an exception.
     *
     * Sometimes you just want to pass informations to your application, this method allows you to transfer
     * a message to your error api server.
     *
     * Example of sending a message
     *
     * ```php
     * Yii::$app->errorHandler->transferMessage('Something went wrong here!', __FILE__, __LINE__);
     * ```
     *
     * @param string $message The message you want to send to the error api server.
     * @param string $file The you are currently send the message (use __FILE__)
     * @param string $line The line you want to submit (use __LINE__)
     * @return bool|null
     */
    public function transferMessage($message, $file = __FILE__, $line = __LINE__)
    {
        return $this->apiServerSendData($this->getExceptionArray([
            'message' => $message,
            'file' => $file,
            'line' => $line,
        ]));
    }
    
    /**
     * Send the array data to the api server.
     *
     * @param array $data The array to be sent to the server.
     * @return boolean|null true/false if data has been sent to the api successfull or not, null if the transfer is disabled.
     */
    private function apiServerSendData(array $data)
    {
        if ($this->transferException) {
            $curl = new Curl();
            $curl->post(Url::ensureHttp(rtrim($this->api, '/')).'/create', [
                'error_json' => Json::encode($data),
            ]);
            return !$curl->error;
        }
        
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function renderException($exception)
    {
        if ($exception instanceof NotFoundHttpException || !$this->transferException) {
            return parent::renderException($exception);
        }
        
        $this->apiServerSendData($this->getExceptionArray($exception));
        
        return parent::renderException($exception);
    }

    /**
     * Get an readable array to transfer from an exception
     *
     * @param mixed $exception Exception object
     * @return array An array with transformed exception data
     */
    public function getExceptionArray($exception)
    {
        $_message = 'Uknonwn exception object, not instance of \Exception.';
        $_file = 'unknown';
        $_line = 0;
        $_trace = [];
        $_previousException = [];
        
        if (is_object($exception)) {
            $prev = $exception->getPrevious();
            
            if (!empty($prev)) {
                $_previousException = [
                    'message' => $prev->getMessage(),
                    'file' => $prev->getFile(),
                    'line' => $prev->getLine(),
                    'trace' => $this->buildTrace($prev),
                ];
            }
            
            $_trace = $this->buildTrace($exception);
            $_message = $exception->getMessage();
            $_file = $exception->getFile();
            $_line = $exception->getLine();
        } elseif (is_string($exception)) {
            $_message = 'exception string: ' . $exception;
        } elseif (is_array($exception)) {
            $_message = isset($exception['message']) ? $exception['message'] : 'exception array dump: ' . print_r($exception, true);
            $_file = isset($exception['file']) ? $exception['file'] : __FILE__;
            $_line = isset($exception['line']) ? $exception['line'] : __LINE__;
        }

        return [
            'message' => $_message,
            'file' => $_file,
            'line' => $_line,
            'requestUri' => (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : null,
            'serverName' => (isset($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : null,
            'date' => date('d.m.Y H:i'),
            'trace' => $_trace,
            'previousException' => $_previousException,
            'ip' => (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : null,
            'get' => (isset($_GET)) ? $_GET : [],
            'post' => (isset($_POST)) ? $_POST : [],
            'session' => (isset($_SESSION)) ? $_SESSION : [],
            'server' => (isset($_SERVER)) ? $_SERVER : [],
        ];
    }
    
    private function buildTrace($exception)
    {
        $_trace = [];
        foreach ($exception->getTrace() as $key => $item) {
            $_trace[$key] = [
                'file' => isset($item['file']) ? $item['file'] : null,
                'line' => isset($item['line']) ? $item['line'] : null,
                'function' => isset($item['function']) ? $item['function'] : null,
                'class' => isset($item['class']) ? $item['class'] : null,
            ];
        }
        return $_trace;
    }
}
