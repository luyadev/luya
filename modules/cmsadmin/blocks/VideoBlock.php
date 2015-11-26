<?php

namespace cmsadmin\blocks;

class VideoBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public $cacheEnabled = true;

    public function name()
    {
        return 'Video';
    }

    public function icon()
    {
        return 'videocam';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'url', 'label' => 'Video URL', 'type' => 'zaa-text'],
            ],
            'cfgs' => [
                [
                    'var' => 'controls',
                    'label' => 'Controls ausblenden?',
                    'type' => 'zaa-checkbox',
                ],
            ],
        ];
    }

    public function getFieldHelp()
    {
        return [
            'url' => 'Es werden Vimeo oder Youtube URLs unterstützt.',
            'controls' => 'Diese Option wird momentan nur von Youtube unterstützt.',
        ];
    }

    public function constructYoutubeUrl($scheme, $host, $query)
    {
        $url = '';
        if (($pos = strpos($query, 'v=')) !== false) {
            $videoId = substr($query, $pos + 2);

            $url = $scheme . '://' . $host . '/embed/' . $videoId;

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
        ];
    }

    public function twigFrontend()
    {
        return '{% if extras.url is not empty %}<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="{{ extras.url }}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if extras.url is not empty %}<div class="video-container" style="margin:100px"><iframe width="640" height="480" src="{{ extras.url }}" frameborder="0" allowfullscreen></iframe></div>{% else %}<span class="block__empty-text">Es wurde noch keine gültige Video URL angegeben.</span>{% endif %}';
    }
}
