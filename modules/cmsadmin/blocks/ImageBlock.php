<?php

namespace cmsadmin\blocks;

use Yii;
use cebe\markdown\GithubMarkdown;
use cmsadmin\Module;
use admin\storage\admin\storage;

class ImageBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public $cacheEnabled = true;

    public $_parser = null;

    public function getParser()
    {
        if ($this->_parser === null) {
            $this->_parser = new GithubMarkdown();
            $this->_parser->enableNewlines = true;
        }

        return $this->_parser;
    }
    
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
        ];
    }

    public function getText()
    {
        $text = $this->getVarValue('caption');

        if ($this->getVarValue('textType') == 1) {
            $text = $this->getParser()->parse($text);
        }

        return $text;
    }

    public function extraVars()
    {
        return [
            'image' => $this->zaaImageUpload($this->getVarValue('imageId')),
            'imageAdmin' => $this->zaaImageUpload($this->getVarValue('imageId', 'medium-thumbnail')),
            'text' => $this->getText()
        ];
    }

    public function twigFrontend()
    {
        return '{% if extras.image is not empty %}
                <div class="image">
                    <figure>
                        <img class="img-responsive" src="{{extras.image.source}}" {% if vars.caption is not empty %}alt="{{vars.caption}}" title="{{vars.caption}}"{% endif %} border="0" />
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
        $image = '{% if extras.imageAdmin.source %}<p><img src="{{extras.imageAdmin.source}}" border="0" style="max-width: 100%;" /><p>{% else %}<span class="block__empty-text">' . Module::t('block_image_no_image') . '</span>{% endif %}';
        $image.= '{% if vars.caption is not empty %}{{vars.caption}}{% endif %}';

        return $image;
    }
}
