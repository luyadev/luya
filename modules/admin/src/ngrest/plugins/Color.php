<?php

namespace admin\ngrest\plugins;

class Color extends \admin\ngrest\base\Plugin
{
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
        /*
        $element = $doc->createElement('span', '&nbsp;');
        $element->setAttribute('style', 'font-size:14.5px; padding-left:30px; background-color : #{{item.'.$this->name.'}}');
        $doc->appendChild($element);

        return $doc;
        */
    }

    public function renderCreate($id, $ngModel)
    {
        throw new \Exception('Error: there is no create implementation for ColorPlugin yet!');
    }

    public function renderUpdate($id, $ngModel)
    {
        throw new \Exception('Error: there is no update implementation for ColorPlugin yet!');
    }
}
