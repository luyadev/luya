<?php

namespace cms\helpers;

use Yii;

/**
 * TagParser to convert CMS Module Tags into HTML Tags
 * 
 * Available encoding tags:
 * 
 * + link[123]
 * + link[123](Link label)
 * + link[http://www.google.ch](Link label)
 * + file[123]
 * + file[123](File label)
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class TagParser
{
    /**
     * @var string Base regular expression to determine function, values and value-sub informations.
     * @see https://regex101.com/r/tI7pK1/3 - Online Regex tester
     */
    const REGEX = '/(?<function>link|file)\[(?<value>.*?)\](\((?<sub>.*?)\))?/mi';

    /**
     * Convert the CMS-Tags into HTML-Tags.
     * 
     * @param string $content The content where the CMS-Tags should be found and convert into Html-Tags.
     * @return string The converted output of $content.
     */
    public static function convert($content)
    {
        // verify if content is a string otherwhise just return the original provided content
        if (!is_string($content)) { 
            return $content;
        }
        // find all tags based on the REGEX expression
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
                case 'file':
                    $replace = static::functionFile($row);
                    break;
            }

            if ($replace !== null) {
                $content = preg_replace('['.preg_quote($row[0]).']mi', $replace, $content, 1);
            }
        }

        return $content;
    }

    private static function functionLink($result)
    {
        $alias = false;
        $external = true;
        if (is_numeric($result['value'])) {
            $menuItem = Yii::$app->menu->find()->where(['nav_id' => $result['value']])->with('hidden')->one();
            if ($menuItem) {
                $href = $menuItem->link;
                $alias = $menuItem->title;
                $external = false;
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

        $class = $external ? 'link-external' : 'link-internal';
        $target = $external ? 'target="_blank"' : null;
        return '<a href="'.$href.'" label="'.$label.'" class="'.$class.'" '.$target.'>'.$label.'</a>';
    }
    
    private static function functionFile($result)
    {
        $file = Yii::$app->storage->getFile($result['value']);
        
        if ($file) {
            $name = isset($result['sub']) ? $result['sub'] : $file->name;
            $source = $file->sourceStatic;
            
            return '<a href="'.$source.'" target="_blank">'.$name.'</a>';
        }
    }
}
