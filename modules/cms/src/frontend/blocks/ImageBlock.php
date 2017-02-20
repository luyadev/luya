<?php

namespace luya\cms\frontend\blocks;

use Yii;
use luya\cms\frontend\Module;
use luya\TagParser;
use luya\cms\frontend\blockgroups\MediaGroup;
use luya\cms\helpers\BlockHelper;
use luya\cms\base\PhpBlock;
use luya\web\ExternalLink;

/**
 * Image Block.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class ImageBlock extends PhpBlock
{
    /**
     * @inheritdoc
     */
    public $module = 'cms';

    /**
     * @inheritdoc
     */
    public $cacheEnabled = true;

    /**
     * @inheritdoc
     */
    public function name()
    {
        return Module::t('block_image_name');
    }
    
    /**
     * @inheritdoc
     */
    public function blockGroup()
    {
        return MediaGroup::class;
    }

    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'crop';
    }

    /**
     * @inheritdoc
     */
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
                ['var' => 'divCssClass', 'label' => Module::t('block_cfg_additonal_css_class'), 'type' => self::TYPE_TEXT],
            ],
        ];
    }

    /**
     * Get the Text as html or p enclosed if empty null is returned.
     *
     * @return string|null
     */
    public function getText()
    {
        $text = $this->getVarValue('caption');

        if ($this->getVarValue('textType') == 1) {
            return TagParser::convertWithMarkdown($text);
        }

        return empty($text) ? null : '<p>' . nl2br($text) . '</p>';
    }
    
    /**
     * Get the Link Object.
     *
     * Linkable resources must implement {{luya\web\LinkInterface}}.
     *
     * @return \luya\web\ExternalLink|\luya\cms\menu\Item|boolean
     */
    public function getLinkObject()
    {
        if ($this->getCfgValue('externalLink', false)) {
            return new ExternalLink(['href' => $this->getCfgValue('externalLink', false)]);
        }
        
        if ($this->getCfgValue('internalLink', false)) {
            return Yii::$app->menu->find()->where(['nav_id' => $this->getCfgValue('internalLink')])->one();
        }
        
        return false;
    }

    /**
     * @inheritdoc
     */
    public function extraVars()
    {
        return [
            'image' => BlockHelper::imageUpload($this->getVarValue('imageId')),
            'imageAdmin' => BlockHelper::imageUpload($this->getVarValue('imageId', 'medium-thumbnail')),
            'text' => $this->getText(),
            'link' => $this->getLinkObject(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function admin()
    {
        $image = '{% if extras.imageAdmin.source %}<p><img src="{{extras.imageAdmin.source}}"{% if cfgs.width %} width="{{cfgs.width}}"{% endif %}{% if cfgs.height %} height="{{cfgs.height}}"{% endif %} border="0" style="max-width: 100%;"></p>';
        $image.= '{% else %}<span class="block__empty-text">' . Module::t('block_image_no_image') . '</span>{% endif %}';
        $image.= '{% if vars.caption is not empty %}{{extras.text}}{% endif %}';

        return $image;
    }
}
