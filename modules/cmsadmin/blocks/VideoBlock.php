<?php

namespace cmsadmin\blocks;

class VideoBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

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
                ['var' => 'url', 'label' => 'Video URL (Vimeo oder Youtube)', 'type' => 'zaa-text'],
            ],
            'cfgs' => [
                [
                    'var' => 'controls',
                    'label' => 'Controls ausblenden? (Wird nicht von allen Playern unterstützt)',
                    'type' => 'zaa-checkbox',
                ],
            ],
        ];
    }

    public function constructYoutubeUrl($scheme, $host, $path, $query)
    {
        if (($pos = strpos($query, 'v=')) !== false) {
            $videoId = substr($query, $pos + 2);

            $url = $scheme . '://' . $host . '/embed/' . $videoId;

            if ($this->getCfgValue('controls')) {
                $url .= '?rel=0&amp;controls=0&amp;showinfo=0';
            } else {
                $url .= '?' . $this->getCfgValue('controls');
            }
        } else {
            $url = '';
        }
        return $url;
    }

    public function constructVimeoUrl($scheme, $host, $path, $query)
    {
        $path = trim($path, '/');
        $url = '';
        if (is_numeric($path)) {
            $url = 'https://player.vimeo.com/video/' . $path;

            $url .= '?color=0c88dd&title=0&byline=0&portrait=0&badge=0';
        }
        return $url;
    }

    public function constructUrl()
    {
        $scheme = parse_url($this->getVarValue('url'), PHP_URL_SCHEME);
        $host = parse_url($this->getVarValue('url'), PHP_URL_HOST);
        $path = parse_url($this->getVarValue('url'), PHP_URL_PATH);
        $query = parse_url($this->getVarValue('url'), PHP_URL_QUERY);

        if ($host == 'www.youtube.com') {
            return $this->constructYoutubeUrl($scheme, $host, $path, $query);
        } elseif (($host == 'www.vimeo.com') || (($host == 'vimeo.com'))) {
            return $this->constructVimeoUrl($scheme, $host, $path, $query);
        } else {
            return '';
        }
    }

    public function extraVars()
    {
        return [
            'url' => $this->constructUrl()
        ];
    }

    public function twigFrontend()
    {
        return '{% if extras.url is not empty %}<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="{{ extras.url }}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if vars.url is not empty %}<div class="video-container" style="margin:100px"><iframe width="640" height="480" src="{{ extras.url }}" frameborder="0" allowfullscreen></iframe></div>{% else %}<span class="block__empty-text">Es wurde noch keine Video URL angegeben.</span>{% endif %}';
    }
}
