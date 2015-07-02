<?php

namespace cms\widgets;

use Yii;
use admin\models\Lang;


class LanguageSwitcherWidget extends \yii\base\Widget
{
    public $message = null;

    public function run()
    {
        $langData = Lang::find()->asArray()->all();

        $navId = Yii::$app->links->findOneByArguments(['url' => Yii::$app->links->activeLink, 'lang' => Yii::$app->composition->getKey('langShortCode')])['id'];

        $html = '<ul>';

        foreach($langData as $lang) {

            $html .= '<li style="display:inline;margin-right:5px"><a href="'.$lang['short_code'].'/'.Yii::$app->links->findOneByArguments(['id' => $navId, 'lang_id' => $lang['id']])['url'].'">'.$lang['short_code'].'</a></li>';
        }

        $html .= '</ul>';

        return $html;
    }
}