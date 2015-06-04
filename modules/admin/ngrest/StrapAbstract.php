<?php

namespace admin\ngrest;

use yii\base\View;

throw new \Exception("deprecated: use \\admin\\ngrest\\base\\ActiveWindow instead!");

/*
abstract class StrapAbstract implements \admin\ngrest\StrapInterface
{
    private $itemId = false;

    public $config = false;

    protected $view = null;

    public function getView()
    {
        if ($this->view === null) {
            $this->view = new View();
        }

        return $this->view;
    }

    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

    public function getItemId()
    {
        return $this->itemId;
    }

    public function setConfig($strapConfig)
    {
        $this->config = $strapConfig;
    }

    public function response($success = true, $transport)
    {
        return ['error' => !$success, 'transport' => $transport];
    }
}
*/