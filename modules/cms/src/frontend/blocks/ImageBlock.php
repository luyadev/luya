<?php

namespace luya\cms\frontend\blocks;

use Yii;
use luya\cms\frontend\Module;
use luya\TagParser;
use luya\cms\base\TwigBlock;

/**
 * Display Block
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class ImageBlock extends TwigBlock
{
    public $module = 'cms';

    public $cacheEnabled = true;

    public function name()
    {
        return Module::t('block_image_name');
    }

    public function icon()
    {
        return 'crop';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'imageId', 'label' => Module::t('block_image_imageid_label'), 'type' => 'zaa-image-upload'],
                ['var' => 'caption', 'label' => Module::t('block_image_caption_label'), 'type' => 'zaa-textarea'],
                ['var' => 'textType', 'label' => Module::t('block_text_texttype_label'), 'initvalue' => 0, 'type' => 'zaa-select', 'options' => [
                        ['value' => 0, 'label' => Module::t('block_text_texttype_normal')],
                        ['value' => 1, 'label' => Module::t('block_text_texttype_markdown')],
                    ],
                ],
            ],
            'cfgs' => [
                ['var' => 'width', 'label' => Module::t('block_image_fixed_width'), 'type' => 'zaa-text'],
                ['var' => 'height', 'label' => Module::t('block_image_fixed_height'), 'type' => 'zaa-text'],
                ['var' => 'internalLink', 'label' => Module::t('block_image_internallink_label'), 'type' => 'zaa-cms-page'],
                ['var' => 'externalLink', 'label' => Module::t('block_image_externallink_label'), 'type' => 'zaa-text'],
                ['var' => 'cssClass', 'label' => Module::t('block_image_cfg_css_class'), 'type' => 'zaa-text'],
            ],
        ];
    }

    public function getText()
    {
        $text = $this->getVarValue('caption');

        if ($this->getVarValue('textType') == 1) {
            return TagParser::convertWithMarkdown($text);
        }

        return $text;
    }

    public function extraVars()
    {
        $linkIsExternal = true;
        $link = $this->getCfgValue('externalLink', false);
        
        if (!$link && $this->getCfgValue('internalLink', false)) {
            $linkIsExternal = false;
            $link = Yii::$app->menu->find()->where(['nav_id' => $this->getCfgValue('internalLink')])->one();
            if ($link) {
                $link = $link->link;
            } else {
                $link = false;
            }
        }

        return [
            'image' => $this->zaaImageUpload($this->getVarValue('imageId')),
            'imageAdmin' => $this->zaaImageUpload($this->getVarValue('imageId', 'medium-thumbnail')),
            'text' => $this->getText(),
            'link' => $link,
            'linkIsExternal' => $linkIsExternal
        ];
    }

    public function twigFrontend()
    {
        return '{% if extras.image is not empty %}
                <div class="image">
                    <figure>
                        {% if extras.link %}
                            <a class="text-teaser" href="{{ extras.link }}"{% if extras.linkIsExternal %} target="_blank"{% endif %}>
                        {% endif %}
                        
                            <img class="img-responsive {{cfgs.cssClass}}" src="{{extras.image.source}}" {% if vars.caption is not empty %}alt="{{vars.caption}}" title="{{vars.caption}}"{% endif %}{% if cfgs.width %} width="{{cfgs.width}}"{% endif %}{% if cfgs.height %} height="{{cfgs.height}}"{% endif %} border="0" />
                            
                        {% if extras.link %}
                            </a>
                        {% endif %}
                        
                        {% if extras.text is not empty %}
                            <figcaption>
                            {% if vars.textType == 1 %}{{ extras.text }}{% else %}<p>{{ extras.text|nl2br }}</p>{% endif %}
                            </figcaption>
                        {% endif %}
                    </figure>
                </div>
            {% endif %}';
    }

    public function twigAdmin()
    {
        $image = '{% if extras.imageAdmin.source %}<p><img src="{{extras.imageAdmin.source}}"{% if cfgs.width %} width="{{cfgs.width}}"{% endif %}{% if cfgs.height %} height="{{cfgs.height}}"{% endif %} border="0" style="max-width: 100%;" /><p>{% else %}<span class="block__empty-text">' . Module::t('block_image_no_image') . '</span>{% endif %}';
        $image.= '{% if vars.caption is not empty %}{{vars.caption}}{% endif %}';

        return $image;
    }
}
