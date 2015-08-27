<?php

namespace admin\ngrest\base;

abstract class ActiveWindow implements \admin\ngrest\interfaces\ActiveWindow
{
    public $config = false;

    public $module = null;

    private $_itemId = false;

    private $_view = null;

    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = new \admin\ngrest\base\View();
            $this->_view->id = strtolower(((new \ReflectionClass($this))->getShortName()));
            $this->_view->module = $this->module;
        }

        return $this->_view;
    }

    public function render($name, array $params = [])
    {
        return $this->getView()->render($name, $params);
    }

    public function setItemId($itemId)
    {
        $this->_itemId = $itemId;
    }

    public function getItemId()
    {
        return $this->_itemId;
    }

    public function setConfig(array $activeWindowConfig)
    {
        $this->config = $activeWindowConfig;
    }

    public function response($success = true, $transport)
    {
        return ['error' => !$success, 'transport' => $transport];
    }
}
