<?php
namespace admin\ngrest;

use yii\base\View;

abstract class StrapAbstract
{
    private $itemId = false;

    public $config = false;

    protected $view = null;

    public function __construct()
    {
        $this->view = new View();
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
