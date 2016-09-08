<?php

namespace luya\cms\tags;

use Yii;
use luya\tag\BaseTag;
use yii\helpers\Html;
use luya\helpers\Url;

class LinkTag extends BaseTag
{
    public function readme()
    {
        return <<<EOT
Generate a link to a page or an internal/external url.    
EOT;
    }

    public function parse($value, $sub)
    {
        $alias = false;
        $external = true;
        if (is_numeric($value)) {
            $menuItem = Yii::$app->menu->find()->where(['nav_id' => $value])->with('hidden')->one();
            if ($menuItem) {
                $href = $menuItem->link;
                $alias = $menuItem->title;
                $external = false;
            } else {
                $href = '#link_not_found';
            }
        } else {
            if (substr($value, 0, 2) == '//') {
                $href = preg_replace('#//#', Url::base(true) . '/', $value, 1);
                $external = false;
            } else {
                $href = $value;
                if (preg_match('#https?://#', $href) === 0) {
                    $href = 'http://'.$href;
                }
            }
        }
        
        if (!empty($sub)) {
            $label = $sub;
        } else {
            if ($alias) {
                $label = $alias;
            } else {
                $label = $href;
            }
        }
        
        return Html::a($label, $href, ['class' => $external ? 'link-external' : 'link-internal', 'label' => $label, 'target' => $external ? '_blank' : null]);
    }
}