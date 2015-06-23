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
        return 'mdi-av-videocam';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'url', 'label' => 'Video URL', 'type' => 'zaa-text'],
            ],
            'cfgs' => [
                ['var' => 'controls', 'label' => 'Controls ausblenden?', 'type' => 'zaa-select', 'options' =>
                    [
                        ['value' => '0', 'label' => 'Nein'],
                        ['value' => '1', 'label' => 'Ja'],
                    ],
                ],
            ]
        ];
    }

    public function constructUrl()
    {
        $scheme  = parse_url($this->getVarValue('url'), PHP_URL_SCHEME);
        $host    = parse_url($this->getVarValue('url'), PHP_URL_HOST);
        $path    = parse_url($this->getVarValue('url'), PHP_URL_PATH);
        $query   = parse_url($this->getVarValue('url'), PHP_URL_QUERY);

        // youtube embed url constructing

        if (($pos = strpos($query, "v=")) !== FALSE) {
            $videoId = substr($query, $pos+2);

            $url = $scheme.'://'.$host.'/embed/'.$videoId;

            if($this->getCfgValue('controls') == 1) {
                $url .= '?rel=0&amp;controls=0&amp;showinfo=0';
            }

        } else {
            // not supported yet
            $url = "";
        }

        return $url;
    }

    public function extraVars()
    {
        return [
            'url' => $this->constructUrl(),
        ];
    }

    public function twigFrontend()
    {
        return '{% if extras.url is not empty %}<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="{{ extras.url }}"></iframe></div>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if vars.url is not empty %}<div class="video-container"><iframe width="640" height="480" src="{{ extras.url }}" frameborder="0" allowfullscreen></iframe></div>{% else %}<span class="block__empty-text">Es wurde noch keine Video URL angegeben.</span>{% endif %}';
    }
}
