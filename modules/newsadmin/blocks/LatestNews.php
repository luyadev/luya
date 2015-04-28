<?php

namespace newsadmin\blocks;

class LatestNews extends \cmsadmin\base\Block
{
    public function name()
    {
        return 'News: Latest Headlines';
    }
    
    public function config()
    {
        return [
            "cfgs" => [
                ['var' => 'limit', 'label' => 'News Num Rows', 'type' => 'zaa-input-text'],
                ['var' => 'nav_item_id', 'label' => 'Nav_Item_Id where module is running', 'type' => 'zaa-input-text'],
            ]  
        ];
    }
    
    public function extraVars()
    {
        return [
            "items" => \newsadmin\models\Article::find()->limit($this->getCfgValue('limit', 10))->all(),
        ];
    }
    
    public function twigAdmin()
    {
        return '<ul>{% for item in extras.items %}<li>{{ item.title }}</li>{% endfor %}</ul>';
    }
    
    /**
     * to force a project custom twig render use: return $this->render('latest_news.twig');
     */
    public function twigFrontend()
    {
        return '<ul>{% for item in extras.items %}<li><a href="{{ item.getDetailUrl(cfgs.nav_item_id) }}">{{ item.title }}</a></li>{% endfor %}</ul>';
    }
}