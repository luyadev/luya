<?php
namespace app\blocks;

class WellBlock extends \cmsadmin\base\Block
{
    public function config()
    {
        return [
            'placeholders' => [
                ["var" => "content", "label" => "Inhalte"]
            ]
        ];
    }

    public function name()
    {
        return 'Hinweis (well)';
    }

    public function icon()
    {
        return 'info_outline';
    }

    public function twigFrontend()
    {
        return '<div class="well">{{placeholders.content}}</div>';
    }

    public function twigAdmin()
    {
        return '<div style="padding:4px; background-color:#F0F0F0;">{{placeholders.content}}</div>';
    }
}