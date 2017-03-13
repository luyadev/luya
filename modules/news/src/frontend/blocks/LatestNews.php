<?php

namespace luya\news\frontend\blocks;

use luya\cms\models\NavItem;
use luya\news\models\Article;
use luya\cms\base\PhpBlock;

class LatestNews extends PhpBlock
{
    public $module = 'news';

    private $_dropdown = [];

    public function icon()
    {
        return 'view_headline';
    }

    public function init()
    {
        foreach (NavItem::fromModule('news') as $item) {
            $this->_dropdown[] = ['value' => $item->id, 'label' => $item->title];
        }
    }

    public function name()
    {
        return 'News: Latest Headlines';
    }

    public function config()
    {
        return [
            'cfgs' => [
                ['var' => 'limit', 'label' => 'Anzahl News Einträge', 'type' => 'zaa-text'],
                ['var' => 'nav_item_id', 'label' => 'Newsseite für Detailansicht', 'type' => 'zaa-select', 'options' => $this->_dropdown],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'items' => Article::getAvailableNews($this->getCfgValue('limit', 10)),
        ];
    }

    public function admin()
    {
        return '<ul>{% for item in extras.items %}<li>{{ item.title }}</li>{% endfor %}</ul>';
    }

    public function twigFrontend()
    {
        return '<ul>{% for item in extras.items %}<li><a href="{{ item.getDetailUrl(cfgs.nav_item_id) }}">{{ item.title }}</a></li>{% endfor %}</ul>';
    }
}
