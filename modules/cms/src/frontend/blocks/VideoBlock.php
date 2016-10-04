<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\base\TwigBlock;

/**
 * Embed YouTube and Vimeo video Block.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class VideoBlock extends TwigBlock
{
    public $module = 'cms';

    public $cacheEnabled = true;

    public function name()
    {
        return Module::t('block_video_name');
    }

    public function icon()
    {
        return 'videocam';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'url', 'label' => Module::t('block_video_url_label'), 'type' => 'zaa-text'],
            ],
            'cfgs' => [
                ['var' => 'controls', 'label' => Module::t('block_video_controls_label'), 'type' => 'zaa-checkbox'],
                ['var' => 'width', 'label' => Module::t('block_video_width_label'), 'type' => 'zaa-number'],
            ],
        ];
    }

    public function getFieldHelp()
    {
        return [
            'url' => Module::t('block_video_help_url'),
            'controls' => Module::t('block_video_help_controls'),
            'width' => Module::t('block_video_help_width'),
        ];
    }

    public function constructYoutubeUrl($scheme, $host, $query)
    {
        $url = '';
        parse_str($query, $params);
        if (isset($params['v'])) {
            $url = $scheme . '://' . $host . '/embed/' . $params['v'];

            if ($this->getCfgValue('controls')) {
                $url .= '?rel=0&amp;controls=0&amp;showinfo=0';
            } else {
                $url .= '?' . $this->getCfgValue('controls');
            }
        }
        return $url;
    }

    public function constructVimeoUrl($path)
    {
        $path = trim($path, '/');
        $url = '';
        if (is_numeric($path)) {
            $url = 'https://player.vimeo.com/video/' . $path . '?color=0c88dd&title=0&byline=0&portrait=0&badge=0';
        }
        return $url;
    }

    public function constructUrl()
    {
        $urlComponents = parse_url($this->getVarValue('url'));
        $correctUrl = isset($urlComponents['scheme']) && isset($urlComponents['host']);

        if (($this->getVarValue('url', null) === null) || !$correctUrl) {
            return null;
        }

        if (($urlComponents['host'] == 'www.youtube.com') || ($urlComponents['host'] == 'youtube.com') || (isset($urlComponents['query']))) {
            return $this->constructYoutubeUrl($urlComponents['scheme'], $urlComponents['host'], $urlComponents['query']);
        } elseif (($urlComponents['host'] == 'www.vimeo.com') || ($urlComponents['host'] == 'vimeo.com') || (isset($urlComponents['path']))) {
            return $this->constructVimeoUrl($urlComponents['path']);
        }
        return null;
    }

    public function extraVars()
    {
        return [
            'url' => $this->constructUrl(),
            'width' => $this->getCfgValue('width', 0),
        ];
    }

    public function twigFrontend()
    {
        return '{% if extras.url is not empty %}{% if extras.width %}<div style="width:{{ extras.width }}">{% endif %}<div class="embed-responsive embed-responsive-16by9">'.
        '<iframe class="embed-responsive-item" src="{{ extras.url }}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>{% if extras.width %}</div>{% endif %}</div>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if extras.url is not empty %}<div style="margin:25px;width:300px"><div class="video-container"><iframe width="640" height="480" src="{{ extras.url }}" frameborder="0" allowfullscreen></iframe></div></div>{% else %}<span class="block__empty-text">' . Module::t('block_video_no_video') . '</span>{% endif %}';
    }
}
