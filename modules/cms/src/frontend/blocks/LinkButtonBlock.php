<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use Yii;
use luya\cms\base\TwigBlock;

/**
 * Simple button element with a link function
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class LinkButtonBlock extends TwigBlock
{
    public $cacheEnabled = true;

    public function name()
    {
        return Module::t('block_link_button_name');
    }

    public function icon()
    {
        return 'link';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'label', 'label' => Module::t('block_link_button_btnlabel_label'), 'type' => 'zaa-text'],
                ['var' => 'linkData', 'label' => Module::t('block_link_button_btnhref_label'), 'type' => 'zaa-link'],
            ],
            'cfgs' => [
                [
                    'var' => 'targetBlank',
                    'label' => Module::t('block_link_button_targetblank_label'),
                    'type' => 'zaa-checkbox'
                ],
                [
                    'var' => 'simpleLink',
                    'label' => Module::t('block_link_button_simpleLink_label'),
                    'type' => 'zaa-checkbox'
                ],
            ],
        ];
    }

    public function getLinkTarget()
    {
        $linkData = $this->getVarValue('linkData', null);
        $data = null;
        if ($linkData) {
            if ($linkData['type'] == '1') {
                $menu = Yii::$app->menu->find()->where(['nav_id' => $linkData['value']])->one();
                if ($menu) {
                    $data = $menu->getLink();
                }
            }
            if ($linkData['type'] == '2') {
                $data = $linkData['value'];
            }
        }
        return $data;
    }
    
    public function extraVars()
    {
        return [
            'linkTarget' => $this->getLinkTarget(),
            'cssClass' => $this->getCfgValue('simpleLink', 'btn btn-default'),
        ];
    }

    public function twigFrontend()
    {
        return '{% if extras.linkTarget is not empty %}<a class="{{ extras.cssClass }}"{% if cfgs.targetBlank == 1  %}target="_blank" ' .
        '{% endif %} href="{{ extras.linkTarget }}">{% if vars.label is not empty %} {{ vars.label }} {% endif %}' .
        '</a>{% endif %}';
    }

    public function twigAdmin()
    {
        return '<p>' . Module::t('block_link_button_name') . ': {% if vars.linkData is empty %}' . Module::t('block_link_button_empty') . '</p>{% else %}' .
        '</p><br/><strong>{% if vars.label is not empty %} {{ vars.label }} {% endif %}</strong>{% endif %}';
    }
}
