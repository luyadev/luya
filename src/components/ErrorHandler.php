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
        
        if (!YII_DEBUG) {
            echo '
<!DOCTYPE html><html style="height:100%"><head><title> 404 Not Found</title></head>
<body style="color: #444; margin:0;font: normal 14px/20px Arial, Helvetica, sans-serif; height:100%; background-color: #fff;">
<div style="height:auto; min-height:100%; ">
<div style="text-align: center; width:800px; margin-left: -400px; position:absolute; top: 30%; left:50%;">
<h1 style="margin:0; font-size:150px; line-height:150px; font-weight:bold;">404</h1>
<h2 style="margin-top:20px;font-size: 30px;">Not Found</h2>
<p>Es ist eine Fehler passiert. Bitte versuchen Sie es zu einem späteren Zeitpunkt erneut.</p>
</div></div></body></html>';
            exit;
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