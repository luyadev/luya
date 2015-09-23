<?php

namespace cms\widgets;

use Yii;

class LanguageSwitcherWidget extends \yii\base\Widget
{
    public $message = null;

    public function run()
    {
        $langData = Yii::$app->links->getActiveLanguages();
        
        $html = '<ul id="languageSwitcher">';

        foreach ($langData as $lang) {
            if (!$lang['link']) {
                $html .= '<li><a href="'.$lang['lang']['short_code'] .'">'.$lang['lang']['short_code'].'</a></li>';
            } else {
                $html .= '<li><a href="'.$lang['lang']['short_code'] . '/' .$lang['link']['url'].'">'.$lang['lang']['short_code'].'</a></li>';
            }
        }

        $html .= '</ul>';

        return $html;
    }
}
