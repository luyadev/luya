<?php
namespace cmsadmin\base;

use yii;

abstract class Block
{
    public $name = null;

    public $jsonConfig = [];

    public $twigFrontend = null;

    public $twigAdmin = null;

    public $renderPath = '@app/views/blocks/';

    public function __construct()
    {
        $fromArray = $this->jsonFromArray();

        if ($fromArray) {
            $this->jsonConfig = json_encode($fromArray);
        }
    }

    public function jsonFromArray()
    {
        return false;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getJsonConfig()
    {
        return $this->jsonConfig;
    }

    public function getTwigFrontend()
    {
        return $this->twigFrontend;
    }

    public function getTwigAdmin()
    {
        return $this->twigAdmin;
    }

    public function getRenderPath()
    {
        return $this->renderPath;
    }

    public function render($twigFile)
    {
        return file_get_contents(yii::getAlias($this->getRenderPath().$twigFile));
    }
}
