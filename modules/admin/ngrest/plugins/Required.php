<?php

namespace admin\ngrest\plugins;

/**
 * @todo set requirements, based on a classname for the element, could also be not the main
 * @todo create an Implicit Plugin Abstract method which does automaticailly look up for the ID element and throw error if not found!
 *
 * @author nadar
 */
class Required extends \admin\ngrest\base\Plugin
{
    public function renderList($doc)
    {
        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->getElementById($this->id);
        $elmn->setAttribute('required', 'required');

        //$span = $doc->createELement("span", "Sie müssen dieses Feld ausfüllen um Daten zu speichern.");
        //$span->setAttribute("ng-show", 'createForm.'.$this->name.'.$error.required');
        //$doc->appendChild($span);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        $elmn = $doc->getElementById($this->id);
        $elmn->setAttribute('required', 'required');

        //$span = $doc->createELement("span", "Sie müssen dieses Feld ausfüllen um Daten zu speichern.");
        //$span->setAttribute("ng-show", 'updateForm.'.$this->name.'.$error.required');
        //$doc->appendChild($span);

        return $doc;
    }
}
