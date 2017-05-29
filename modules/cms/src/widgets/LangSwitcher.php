<?php

namespace luya\cms\widgets;

use Yii;
use luya\web\Composition;
use yii\helpers\Html;
use luya\helpers\ArrayHelper;

/**
 * CMS Lang Switcher Widget.
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
 * ```html
 * <ul class="list-element">
 *     <li><li class="lang-element-item lang-element-item--active"><a class="lang-link-item lang-link-item--active" href="/luya/envs/dev/public_html/">English</a></li></li>
 *     <li><li class="lang-element-item"><a class="lang-link-item" href="/luya/envs/dev/public_html/de">Deutsch</a></li></li>
 * </ul>
 * ```
 *
 * You can configure the elements to match your custom css:
 *
 * ```php
 * LangSwitcher::widget([
 *     'listElementOptions' => ['class' => 'langnav__list'],
 *     'elementOptions' => ['class' => 'langnav__item'],
 *     'linkOptions' => ['class' => 'langnav__link'],
 *     'linkLabel' => function($lang) {
 *         return strtoupper($lang['short_code']);
 *     }
 * ]);
 * ```
 *
 * This configure widget would output the following code:
 *
 * ```html
 * <ul class="langnav__list">
 *     <li class="langnav__item lang-element-item--active"><a class="langnav__link lang-link-item--active" href="/public_html/">DE</a></li>
 *     <li class="langnav__item"><a class="langnav__link" href="/public_html/en">EN</a></li>
 * </ul>
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class LangSwitcher extends \luya\base\Widget
{
    /**
     * @var null|array Singleton container when used for mobile and desktop in order to reduce db requests.
     */
    private static $_dataArray;
    
    /**
     * @var array The Wrapping list element (ul tag) Options to pass.
     *  - tag: Default is ul
     *  - seperator: The seperator for items defaults `\n`.
     *  - class: The class to observe for the elements.
     */
    public $listElementOptions = ['class' => 'list-element'];

    /**
     * @var boolean Decides whether the <ul> tag will be outputted or not
     */
    public $noListTag = false;
    
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
    public $linkActiveClass = 'lang-link-item--active';
    
    /**
     * @var array Options to pass to the link element (a tag).
     */
    public $linkOptions = ['class' => 'lang-link-item'];
    
    /**
     * @var string Options to pass to the link element (a tag). Can also be a callable in order to specific output.
     *
     * - id:
     * - name: The fullname, e.g. English
     * - short_code: The short code, e.g. en
     */
    public $linkLabel = 'name';
    
    /**
     * @var callable A callable function in order to sort the $items (the array key of the items contains the lang short code):
     *
     * ```php
     * 'itemsCallback' => function($items) {
     *     ksort($items);
     *     return $items;
     * }
     * ```
     */
    public $itemsCallback;
    
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
                $linkOptions['class'] = $linkOptions['class'] . ' ' . $this->linkActiveClass;
            } else {
                $linkOptions['class'] = $this->linkActiveClass;
            }
         
            if (isset($elementOptions['class'])) {
                $elementOptions['class'] = $elementOptions['class'] . ' ' . $this->elementActiveClass;
            } else {
                $elementOptions['class'] = $this->elementActiveClass;
            }
        }
        
        $tag = ArrayHelper::remove($elementOptions, 'tag', 'li');
        
        $text = is_callable($this->linkLabel) ? call_user_func($this->linkLabel, $lang) : $lang[$this->linkLabel];
        
        return Html::tag($tag, Html::a($text, $href, $linkOptions), $elementOptions);
    }

    /**
     * Add Singleton Container.
     *
     * @return array
     */
    private static function getDataArray()
    {
        if (self::$_dataArray === null) {
            $currentMenuItem = Yii::$app->menu->current;
            $array = [];
            foreach (Yii::$app->adminLanguage->getLanguages() as $lang) {
                $array[] = [
                    'lang' => $lang,
                    'item' => Yii::$app->menu->find()->where(['nav_id' => $currentMenuItem->navId])->lang($lang['short_code'])->with('hidden')->one(),
                ];
            }
            
            self::$_dataArray = $array;
        }
        
        return self::$_dataArray;
    }
    
    /**
     * @return string The langnav html
     */
    public function run()
    {
        $currentLang = Yii::$app->composition['langShortCode'];
        
        $rule = Yii::$app->menu->currentUrlRule;

        $items = [];

        foreach (self::getDataArray() as $langData) {
            $item = $langData['item'];
            $lang = $langData['lang'];
            
            if ($item) {
                if ($item->type == 2  && !empty($rule)) {
                    $routeParams = [$rule['route']];
                    foreach ($rule['params'] as $key => $value) {
                        $routeParams[$key] = $value;
                    }
                    $compositionObject = Yii::createObject(Composition::className());
                    $compositionObject->off(Composition::EVENT_AFTER_SET);
                    $compositionObject['langShortCode'] = $lang['short_code'];
                    $link = Yii::$app->urlManager->createMenuItemUrl($routeParams, $item->id, $compositionObject);
                } else {
                    $link = $item->link;
                }
                $items[$lang['short_code']] = $this->generateHtml($link, $currentLang == $lang['short_code'], $lang);
            } else {
                $items[$lang['short_code']] = $this->generateHtml(Yii::$app->urlManager->prependBaseUrl($lang['short_code']), $currentLang == $lang['short_code'], $lang);
            }
            
            unset($item, $lang);
        }
        
        if (is_callable($this->itemsCallback)) {
            $items = call_user_func($this->itemsCallback, $items);
        }

        $options = $this->listElementOptions;
        $options['encode'] = false;
        
        $separator = ArrayHelper::remove($options, 'separator', "\n");
        $tag =  ArrayHelper::remove($options, 'tag', "ul");

        if ($this->noListTag) {
            return trim($separator . implode($separator, $items) . $separator);
        }

        return Html::tag($tag, $separator . implode($separator, $items) . $separator, $options);
    }
}
