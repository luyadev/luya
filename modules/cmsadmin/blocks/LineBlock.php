<?php

namespace cmsadmin\blocks;

/**
 * Simple horizontal line block
 */
class LineBlock extends \cmsadmin\base\Block
{
    public $cacheEnabled = true;
    
    public function name()
    {
        return 'Line';
    }

    public function icon()
    {
        return 'remove'; // choose icon from: http://materializecss.com/icons.html
    }

    public function config()
    {
        return [
           'vars' => [
                ['var' => 'lineSpace', 'label' => 'Linien Abstand', 'type' => 'zaa-select', 'options' => [
                    ['value' => '5px', 'label' => '5px Abstand(Oben/Unten)'],
                    ['value' => '10px', 'label' => '10px Abstand(Oben/Unten)'],
                    ['value' => '20px', 'label' => '20px Abstand(Oben/Unten)'],
                    ['value' => '30px', 'label' => '30px Abstand(Oben/Unten)'],
                ], 'initvalue' => '5px'],
                ['var' => 'lineStyle', 'label' => 'Linien Style', 'type' => 'zaa-select', 'options' => [
                    ['value' => 'dotted', 'label' => 'Gepunktet'],
                    ['value' => 'dashed', 'label' => 'Gestrichelt'],
                    ['value' => 'solid', 'label' => 'Durchgängig'],
                ], 'initvalue' => 'solid'],
                ['var' => 'lineWidth', 'label' => 'Linien Breite', 'type' => 'zaa-select', 'options' => [
                    ['value' => '1px', 'label' => '1px'],
                    ['value' => '2px', 'label' => '2px'],
                    ['value' => '3px', 'label' => '3px'],
                ], 'initvalue' => '1px'],
                ['var' => 'lineColor', 'label' => 'Linien Farbe', 'type' => 'zaa-select', 'options' => [
                    ['value' => '#ccc', 'label' => 'Grau'],
                    ['value' => '#000', 'label' => 'Schwarz'],
                ], 'initvalue' => '#ccc']
            ],
        ];
    }

    /**
     * Return an array containg all extra vars. Those variables you can access in the Twig Templates via {{extras.*}}.
     */
    public function extraVars()
    {
        return [
            // add your custom extra vars here
        ];
    }

    /**
     * Available twig variables:
     * @param {{vars.lineSpace}}
     * @param {{vars.lineStyle}}
     * @param {{vars.lineWidth}}
     * @param {{vars.lineColor}}
     */
    public function twigFrontend()
    {
        return '<hr style="border: 0; border-bottom: {{ vars.lineWidth }} {{ vars.lineStyle }} {{ vars.lineColor }}; margin: {{ vars.lineSpace }} 0;"/>';
    }

    /**
     * Available twig variables:
     * @param {{vars.lineSpace}}
     * @param {{vars.lineStyle}}
     * @param {{vars.lineWidth}}
     * @param {{vars.lineColor}}
     */
    public function twigAdmin()
    {
        return '<p>Linien Element<hr/></p>';
    }
}
