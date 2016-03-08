<?php

namespace cms\helpers;

use Yii;

/**
 * Hello link:123123.
 * 
 * link[123]
 * link[123](Href Label)
 * link[http://www.google.ch](Href Label)
 * 
 * file[123]
 * file[123](File Label)
 * 
 * @author nadar
 */
class Parser
{
    const REGEX = '/(?<function>link|file)\[(?<value>.*?)\](\((?<sub>.*?)\))?/mi';

    /**
     * 
     * 
     * @see https://regex101.com/r/tI7pK1/3 - Online Regex tester
     * @param string $content
     */
    public static function encode($content)
    {
        if (is_object($content) || is_array($content)) {
            return $content;
        }
        
        preg_match_all(static::REGEX, $content, $results, PREG_SET_ORDER);

        foreach ($results as $row) {

            // fixed issue when ussing link[] cause value is empty
            if (empty($row['value'])) {
                continue;
            }

            $replace = null;

            switch ($row['function']) {
                case 'link':
                    $replace = static::functionLink($row);
                    break;
            }

            if ($replace !== null) {
                $content = preg_replace('['.preg_quote($row[0]).']mi', $replace, $content, 1);
            }
        }

        return $content;
    }

    public static function functionLink($result)
    {
        $alias = false;
        if (is_numeric($result['value'])) {
            $menuItem = Yii::$app->menu->find()->where(['nav_id' => $result['value']])->with('hidden')->one();
            if ($menuItem) {
                $href = $menuItem->link;
                $alias = $menuItem->title;
            } else {
                $href = '#link_not_found';
            }
        } else {
            $href = $result['value'];

            if (preg_match('#https?://#', $href) === 0) {
                $href = 'http://'.$href;
            }
        }

        if (isset($result['sub'])) {
            $label = $result['sub'];
        } else {
            if ($alias) {
                $label = $alias;
            } else {
                $label = $result['value'];
            }
        }

        return '<a href="'.$href.'">'.$label.'</a>';
    }
}
