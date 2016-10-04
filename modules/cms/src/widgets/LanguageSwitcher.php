<?php

namespace luya\cms\widgets;

use Yii;
use luya\admin\models\Lang;
use luya\web\Composition;

/**
 * Language Switcher for CMS
 *
 * This widget will find all registered languages and display the corresponding like to the
 * provided languages, if there as no like it will link to the home page of this language. The
 * language switcher can event detect composition url rules for other languages based on the
 * current menu item.
 *
 * You can always extend from this class and other proprties you can access trough the `$this->context`
 * variable inside your view.
 *
 * The following code is an example of how the template for this widget could look like:
 *
 * ```html
 * <div class="langnav">
 *   <ul class="langnav__list">
 *   <?php foreach($items as $item): ?>
 *       <li class="langnav__item">
 *       	<a class="langnav__link <?php if ($item['isCurrent']): ?>langnav__link--current<?endif; ?>" href="<?php echo $item['href']; ?>"><?php echo $item['language']['short_code']; ?></a>
 *       </li>
 *   <?php endforeach; ?>
 *   </ul>
 * </div>
 * ```
 *
 * @author nadar
 * @since 1.0.0-beta5
 */
class LanguageSwitcher extends \luya\base\Widget
{
    public function run()
    {
        $currentLang = Yii::$app->composition['langShortCode'];
        
        // Get current link
        $current = Yii::$app->menu->current;
        
        $rule = Yii::$app->menu->currentUrlRule;
        
        $items = [];
        
        // Loop through all languages
        foreach (Yii::$app->adminLanguage->getLanguages() as $lang) {
            // Find item of current link with the lang
            $item = Yii::$app->menu->find()->where(['nav_id' => $current->navId])->lang($lang['short_code'])->with('hidden')->one();
        
            if ($item) {
                $link = $item->link;
                
                if ($item->type == 2  && !empty($rule)) {
                    $routeParams = [$rule['route']];
                    
                    foreach ($rule['params'] as $key => $value) {
                        $routeParams[$key] = $value;
                    }
                    
                    $compositionObject = Yii::createObject(Composition::className());
                    $compositionObject->off(Composition::EVENT_AFTER_SET);
                    $compositionObject['langShortCode'] = $lang['short_code'];
                    $link = Yii::$app->urlManager->createMenuItemUrl($routeParams, $item->id, $compositionObject);
                }
                
                $items[] = [
                    'href' => $link,
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
            'currentLanguage' => Yii::$app->adminLanguage->getLanguageByShortCode($currentLang),
        ]);
    }
}
