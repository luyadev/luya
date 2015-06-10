<?php

namespace luya\base;

trait ErrorHandlerTrait {
    
    public $api = 'http://luya.io/errorapi';
    
    public $transferException = false;
    
    public function renderException($exception)
    {
        if (!$this->transferException) {
            return parent::renderException($exception);
        }
    
        $data = json_encode($this->getExceptionArray($exception));
    
        $curl = new \Curl\Curl();
        $rsp = $curl->post(\luya\helpers\Url::trailing($this->api).'create', [
            'error_json' => $data,
        ]);
    
        if (!YII_DEBUG) {
            return '<html><head><title>Fehler</title></head><body style="padding:40px;"><h2>Seiten Fehler</h2><p>Es ist ein unerwartet Fehler passiert, wir bitten um Entschuldigung. Bitte versuchen Sie es später erneut.</p></body></html>';
        }
    
        return parent::renderException($exception);
    }
    
    /**
     * @todo: catch getPrevious() exception
     * @param object $exception Exception
     * @return multitype:multitype:Ambigous <NULL, unknown>
     */
    public function getExceptionArray($exception)
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
    
        return [
            'message' => $exception->getMessage(),
            'date' => date("d.m.Y H:i"),
            'line' => $exception->getLine(),
            'file' => $exception->getFile(),
            'trace' => $_trace,
            'server' => $_SERVER,
            'get' => $_GET,
            'post' => $_POST,
        ];
    }
    
}