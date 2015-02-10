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
        
        $data = json_encode($this->getSlimTrace($exception));
        
        // @todo call this url via curl?
        // @todo send error 404 default page
        echo $this->getModule()->exceptionUrl . '/create/?jsonData=' . $data;
    }   
    /**
     * @todo: catch getPrevious() exception
     * @param object $exception Exception
     * @return multitype:multitype:Ambigous <NULL, unknown>
     */
    public function getSlimTrace($exception)
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
        
        return $_trace;
    }
}