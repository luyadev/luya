<?php
namespace luya\components;

class ErrorHandler extends \yii\web\ErrorHandler
{
    private $_module = null;
    
    public function getModule()
    {
        if ($this->_module === null) {
            $this->_module = \yii::$app->getModule('luya');
        }
        
        return $this->_module;
    }
    
    public function renderException($exception)
    {
        if (!$this->getModule()->sendException) {
            return parent::renderException($exception);
        }
        
        $data = json_encode($this->getExceptionArray($exception));
        
        // @todo call this url via curl?
        // @todo send error 404 default page
        $curl = new \Curl\Curl();
        $rsp = $curl->post(\luya\helpers\Url::trailing($this->getModule()->exceptionUrl) . 'create', array(
            'error_json' => $data,
        ));
        
        echo "<h1>Fehler</h1>";
        echo "<p>Oops es ist ein Fehler passiert.</p>";
        exit;
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
                "file" => isset($item['file']) ? $item['file'] : null,
                "line" => isset($item['line']) ? $item['line'] : null,
                "function" => isset($item['function']) ? $item['function'] : null,
                "class" => isset($item['class']) ? $item['class'] : null,
            ];
        }
        
        return [
            'message' => $exception->getMessage(),
            'line' => $exception->getLine(),
            'file' => $exception->getFile(),
            'trace' => $_trace,
            'server' => $_SERVER,
            'get' => $_GET,
            'post' => $_POST
        ];
    }
}