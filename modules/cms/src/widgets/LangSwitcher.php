<?php

namespace luya\cms\widgets;

use Yii;
use luya\web\Composition;
use yii\helpers\Html;
use luya\helpers\ArrayHelper;

/**
 * Language Switcher for CMS
 *
 * This widget will find all registered languages and display the corresponding like to the provided languages, 
 * if there as no translation found for the current link, it will point to the home page for this language. The
 * language switcher can even detect composition url rules for other languages based on the current menu item.
 * 
 * ```php
 * LangSwitcher::widget();
 * ```
 * 
 * Generates a list with all items:
 * 
 * ```php
 * <ul class="list-element">
 *     <li><li class="lang-element-item lang-element-item--active"><a class="lang-link-item lang-link-item--active" href="/luya/envs/dev/public_html/">English</a></li></li>
 *     <li><li class="lang-element-item"><a class="lang-link-item" href="/luya/envs/dev/public_html/de">Deutsch</a></li></li>
 * </ul>
 * ```
 * 
 * You can configure the elements to match your custom css:
 * 
 * 
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class LangSwitcher extends \luya\base\Widget
{
    /**
     * @var array The Wrapping list element (ul tag) Options to pass.
     */
    public $listElementOptions = ['class' => 'list-element'];
    
    /**
     * @var array Options to pass to the element (li tag):
     * 
     * - tag: The used tag (defaults is li tag)
     * - class: The class for the element.
     */
    public $elementOptions = ['class' => 'lang-element-item'];
    
    /**
     * @var string The class to set when the element item (li tag) is the current language.
     */
    public $elementActiveClass = 'lang-element-item--active';
    
    /**
     * @var string The class to set when the link item (a tag) is the current language.
     */
    public $LinkActiveClass = 'lang-link-item--active';
    
    /**
     * @var array Options to pass to the link element (a tag).
     */
    public $linkOptions = ['class' => 'lang-link-item'];
    
    /**
     * @var string Options to pass to the link element (a tag):
     * 
     * - id:
     * - name: The fullname, e.g. English
     * - short_code: The short code, e.g. en
     */
    public $linkLabel = 'name';
    
    /**
     * Generate the item element.
     * 
     * @param string $href
     * @param boolean $isActive
     * @param array $lang
     * @return string
     */
    private function generateHtml($href, $isActive, $lang)
    {
        $elementOptions = $this->elementOptions;
        $linkOptions = $this->linkOptions;
        
        if ($isActive) {
            if (isset($linkOptions['class'])) {
                $linkOptions['class'] = $linkOptions['class'] . ' ' . $this->LinkActiveClass;
            } else {
                $linkOptions['class'] = $this->LinkActiveClass;
            }
         
            if (isset($elementOptions['class'])) {
                $elementOptions['class'] = $elementOptions['class'] . ' ' . $this->elementActiveClass;
            } else {
                $elementOptions['class'] = $this->elementActiveClass;
            }
        }
        
        $tag = ArrayHelper::remove($elementOptions, 'tag', 'li');
        
        return Html::tag($tag, Html::a($lang[$this->linkLabel], $href, $linkOptions), $elementOptions);
    }

    /**
     * @return array An array with languages items.
     */
    public function run()
    {
        $currentLang = Yii::$app->composition['langShortCode'];
        $currentMenuItem = Yii::$app->menu->current;
        $rule = Yii::$app->menu->currentUrlRule;

        $items = [];

        // Loop through all languages
        foreach (Yii::$app->adminLanguage->getLanguages() as $lang) {
            // Find item of current link with the lang
            $item = Yii::$app->menu->find()->where(['nav_id' => $currentMenuItem->navId])->lang($lang['short_code'])->with('hidden')->one();

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

                $items[] = $this->generateHtml($link, $currentLang == $lang['short_code'], $lang);
            } else {
                $items[] = $this->generateHtml(Yii::$app->urlManager->prependBaseUrl($lang['short_code']), $currentLang == $lang['short_code'], $lang);
            }
        }

        $options = $this->listElementOptions;
        $options['encode'] = false;
        
        return Html::ul($items, $options);
    }
}
