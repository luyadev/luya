<?php

namespace cms\widgets;

use Yii;

class LanguageSwitcherWidget extends \yii\base\Widget
{
    public $message = null;

    public function run()
    {
        $langData = Yii::$app->links->getActiveLanguages();
        
        $html = '<ul>';

        foreach ($langData as $lang) {
            $html .= '<li style="display:inline;margin-right:5px"><a href="'.$lang['lang'] . '/' .$lang['url'].'">'.$lang['lang'].'</a></li>';
        }

        $html .= '</ul>';

        return $html;
    }
}
