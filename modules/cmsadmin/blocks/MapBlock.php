<?php

namespace cmsadmin\blocks;

class MapBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public function name()
    {
        return 'Karte';
    }

    public function icon()
    {
        return 'mdi-maps-place';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'address', 'label' => 'Adresse', 'type' => 'zaa-text'],
            ],
            'cfgs' => [
                ['var' => 'zoom', 'label' => 'Zoom', 'type' => 'zaa-select', 'initvalue' => '12', 'options' =>
                    [
                        ['value' => '0', 'label' => 'Komplett herausgezoomt'],
                        ['value' => '1', 'label' => '4000 km'],
                        ['value' => '2', 'label' => '2000 km (Welt)'],
                        ['value' => '3', 'label' => '1000 km'],
                        ['value' => '4', 'label' => '400 km (Kontinent)'],
                        ['value' => '5', 'label' => '200 km'],
                        ['value' => '6', 'label' => '100 km (Land)'],
                        ['value' => '7', 'label' => '50 km'],
                        ['value' => '8', 'label' => '30 km'],
                        ['value' => '9', 'label' => '15 km'],
                        ['value' => '10', 'label' => '8 km'],
                        ['value' => '11', 'label' => '4 km'],
                        ['value' => '12', 'label' => '2 km (Stadt)'],
                        ['value' => '13', 'label' => '1 km'],
                        ['value' => '14', 'label' => '400 m (Stadtteil)'],
                        ['value' => '15', 'label' => '200 m'],
                        ['value' => '16', 'label' => '100 m'],
                        ['value' => '17', 'label' => '50 m (Strasse)'],
                        ['value' => '18', 'label' => '20 m'],
                        ['value' => '19', 'label' => '10 m'],
                        ['value' => '20', 'label' => '5 m (Haus)'],
                        ['value' => '21', 'label' => '2.5 m'],
                    ],
                ],
                ['var' => 'maptype', 'label' => 'Katentyp', 'type' => 'zaa-select', 'options' =>
                    [
                        ['value' => 'm', 'label' => 'Strassenkarte'],
                        ['value' => 'k', 'label' => 'Satellitenkarte'],
                        ['value' => 'h', 'label' => 'Satellitenkarte mit Strassennamen'],
                    ],
                ],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'address' => $this->getVarValue('address', 'Zephir Software Design AG, Tramstrasse 66, Münchenstein'),
            'zoom' => $this->getCfgValue('zoom', 15),
            'maptype' => $this->getCfgValue('maptype', 'roadmap'),
        ];
    }

    public function twigFrontend()
    {

        return '{% if vars.address is not empty %}<div class="embed-responsive embed-responsive-16by9"><iframe src="http://maps.google.com/maps?f=q&source=s_q&hl=de&geocode=&q={{ extras.address }}&z={{ extras.zoom }}&t={{ extras.maptype }}&output=embed" width="600" height="450" frameborder="0" style="border:0"></iframe></div>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if vars.address is not empty %}<div class="video-container"><iframe src="http://maps.google.com/maps?f=q&source=s_q&hl=de&geocode=&q={{ extras.address }}&z={{ extras.zoom }}&t={{ extras.maptype }}&output=embed" width="600" height="450" frameborder="0" style="border:0"></iframe></div>{% else %}<span class="block__empty-text">Es wurde noch keine Adresse angegeben.</span>{% endif %}';
    }
}
