<?php

namespace luya\traits;

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
        $curl->post(rtrim($this->api, '/').'/create', [
            'error_json' => Json::encode($this->getExceptionArray($exception)),
        ]);
        
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
        
        if ($exception instanceof \Exception) {
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
            'previousException' => $_previousException,
            'ip' => (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : null,
            'get' => (isset($_GET)) ? $_GET : [],
            'post' => (isset($_POST)) ? $_POST : [],
            'session' => (isset($_SESSION)) ? $_SESSION : [],
            'server' => (isset($_SERVER)) ? $_SERVER : [],
        ];
    }
    
    private function buildTrace(\Exception $exception)
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
