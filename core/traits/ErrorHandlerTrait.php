<?php

namespace luya\traits;

use Yii;
use yii\helpers\Json;
use Curl\Curl;
use luya\helpers\Url;
use luya\helpers\ObjectHelper;
use luya\helpers\StringHelper;

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
     * @var \Curl\Curl|null The curl object from the last error api call.
     * @since 1.0.5
     */
    public $lastTransferCall;
    
    /**
     * @var array An array of exceptions which are whitelisted and therefore NOT TRANSFERED.
     * @since 1.0.5
     */
    public $whitelist = ['yii\web\NotFoundHttpException'];
    
    /**
     * @var array
     * @since 1.0.6
     */
    public $sensitiveKeys = ['password', 'pwd', 'pass', 'passwort', 'pw', 'token', 'hash', 'authorization'];
    
    /**
     * Send a custom message to the api server event its not related to an exception.
     *
     * Sometimes you just want to pass informations from your application, this method allows you to transfer
     * a message to the error api server.
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
            $curl->setOpt(CURLOPT_CONNECTTIMEOUT, 2);
            $curl->setOpt(CURLOPT_TIMEOUT, 2);
            $curl->post(Url::ensureHttp(rtrim($this->api, '/')).'/create', [
                'error_json' => Json::encode($data),
            ]);
            
            $this->lastTransferCall = $curl;
            
            return $curl->isSuccess();
        }
        
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function renderException($exception)
    {
        if (!ObjectHelper::isInstanceOf($exception, $this->whitelist, false) && $this->transferException) {
            $this->apiServerSendData($this->getExceptionArray($exception));
        }
        
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
            'requestUri' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null,
            'serverName' => isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : null,
            'date' => date('d.m.Y H:i'),
            'trace' => $_trace,
            'previousException' => $_previousException,
            'ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null,
            'get' => isset($_GET) ? $this->coverSensitiveValues($_GET, $this->sensitiveKeys) : [],
            'post' => isset($_POST) ? $this->coverSensitiveValues($_POST, $this->sensitiveKeys) : [],
            'session' => isset($_SESSION) ? $this->coverSensitiveValues($_SESSION, $this->sensitiveKeys) : [],
            'server' => isset($_SERVER) ? $this->coverSensitiveValues($_SERVER, $this->sensitiveKeys) : [],
            'profiling' => Yii::getLogger()->profiling,
            'logger' => Yii::getLogger()->messages,
        ];
    }
    
    /**
     * Cover senstive values from a given list of keys.
     * 
     * This applys only for the first key inside the array and does not work recursive.
     * 
     * The main purpose is to remove passwords transferd to api when existing in post, get or session.
     * 
     * @param array $data
     * @param array $key
     * @since 1.0.6
     */
    public function coverSensitiveValues(array $data, array $keys)
    {
        $clean = [];
        foreach ($keys as $key) {
            $kw = strtolower($key);
            foreach ($data as $k => $v) {
                if ($kw == strtolower($k) || StringHelper::startsWith(strtolower($k), $kw)) {
                    $v = str_repeat("*", strlen($v));
                    $clean[$k] = $v;
                }
            }
        }
        
        // the later overrides the former
        return array_merge($data, $clean);
    }
    
    /**
     * Build trace array from exception.
     *
     * @param object $exception
     * @return array
     */
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
