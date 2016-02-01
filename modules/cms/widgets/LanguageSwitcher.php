<?php

namespace cms\widgets;

use Yii;
use admin\models\Lang;

class LanguageSwitcher extends \luya\base\Widget
{
    public function run()
    {
        $currentLang = Yii::$app->composition['langShortCode'];
        
        // Get current link
        $current = Yii::$app->menu->current;
        
        $appendix = Yii::$app->menu->currentAppendix;
        
        $items = [];
        
        // Loop through all languages
        foreach(Lang::find()->asArray()->all() as $lang) {
            // Find item of current link with the lang
            $item = Yii::$app->menu->find()->where(['nav_id' => $current->navId])->lang($lang['short_code'])->with('hidden')->one();
        
            if ($item) {
                $items[] = [
                    'href' => $item->link,
                    'isCurrent' => $currentLang == $lang['short_code'],
                    'language' => $lang,
                ];
            } else {
                $items[] = [
                    'href' => Yii::$app->urlManager->prependBaseUrl($lang['short_code']),
                    'isCurrent' => $currentLang == $lang['short_code'],
                    'language' => $lang,
                ];
            }
        }
        
        return $this->render('index', [
            'items' => $items,
            'currentLanguage' => Lang::find()->where(['short_code' => $currentLang])->asArray()->one(),
        ]);
    }
}