<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\MediaGroup;
use luya\cms\base\PhpBlock;

/**
 * Embed YouTube and Vimeo video Block.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class VideoBlock extends PhpBlock
{
    const PROVIDER_YOUTUBE = 'youtube';
    
    const PROVIDER_YOUTUBE_EMBED_URL = 'https://www.youtube.com/embed/';
    
    const PROVIDER_VIMEO = 'vimeo';
    
    const PROVIDER_VIMEO_EMBED_URL = 'https://player.vimeo.com/video/';
    
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
        return Module::t('block_video_name');
    }

    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'videocam';
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
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'url', 'label' => Module::t('block_video_url_label'), 'type' => self::TYPE_TEXT],
            ],
            'cfgs' => [
                ['var' => 'controls', 'label' => Module::t('block_video_controls_label'), 'type' => self::TYPE_CHECKBOX],
                ['var' => 'width', 'label' => Module::t('block_video_width_label'), 'type' => self::TYPE_NUMBER],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFieldHelp()
    {
        return [
            'url' => Module::t('block_video_help_url'),
            'controls' => Module::t('block_video_help_controls'),
            'width' => Module::t('block_video_help_width'),
        ];
    }
    
    /**
     * Ensure the emebed youtube url based on url var.
     *
     * @return string
     */
    public function embedYoutube()
    {
        parse_str(parse_url($this->getVarValue('url'), PHP_URL_QUERY), $args);
        // ensure if v argument exists
        if (isset($args['v'])) {
            $params['rel'] = 0;
            if ($this->getCfgValue('controls')) {
                $params['controls'] = 0;
            }
            return self::PROVIDER_YOUTUBE_EMBED_URL . $args['v'] . '?' . http_build_query($params);
        }
    }
    
    /**
     * Ensure the emebed vimeo url based on url var.
     *
     * @return string
     */
    public function embedVimeo()
    {
        return self::PROVIDER_VIMEO_EMBED_URL . ltrim(parse_url($this->getVarValue('url'), PHP_URL_PATH), '/');
    }

    /**
     * Construct the url based on url input.
     *
     * @return string
     */
    public function constructUrl()
    {
        if ($this->getVarValue('url')) {
            preg_match('/(?:www\.)?([a-z]+)(?:\.[a-z]+)?/', parse_url($this->getVarValue('url'), PHP_URL_HOST), $match);
            if (isset($match[1])) {
                switch ($match[1]) {
                    case self::PROVIDER_YOUTUBE: return $this->embedYoutube();
                    case self::PROVIDER_VIMEO: return $this->embedVimeo();
                }
            }
        }
        
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function extraVars()
    {
        return [
            'url' => $this->constructUrl(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function admin()
    {
        return '{% if extras.url is not empty %}<div style="margin:25px;width:300px"><div class="video-container"><iframe width="640" height="480" src="{{ extras.url }}" frameborder="0" allowfullscreen></iframe></div></div>{% else %}<span class="block__empty-text">' . Module::t('block_video_no_video') . '</span>{% endif %}';
    }
}
