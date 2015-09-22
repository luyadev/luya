<?php

namespace admin\ngrest\plugins;

use Yii;
use cmsadmin\models\Nav;

class CmsPage extends \admin\ngrest\base\Plugin
{
    private $_pages = null;
    
    public $findParams = [];
    
    public function __construct($findParams = [])
    {
        $this->findParams = $findParams;
    }
    
    public function getPages()
    {
        if ($this->_pages === null) {
            $links = Yii::$app->links->findByArguments($this->findParams);
            foreach($links as $link) {
                $this->_pages[$link['id']] = $link['title'];
            }
        }
        
        return $this->_pages;
    }
    
    public function renderList($doc)
    {
        $doc->appendChild($doc->createElement('span', '{{item.'.$this->name.'}}'));
        // return $doc
        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $this->createBaseElement($doc, 'zaa-cms-page');
        $elmn->setAttribute('options', $this->getServiceName('pages'));
        $doc->appendChild($elmn);
        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }

    public function onAfterFind($fieldValue)
    {
        return (!empty($fieldValue)) ? Nav::findContent($fieldValue) : $fieldValue;
    }
    
    public function serviceData()
    {
        return [
            'pages' => $this->getPages(),
        ];
    }
}
