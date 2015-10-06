<?php

namespace cms\helpers;

/**
 * 
 * Hello link:123123
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
     * Regex Tester
     * 
     * @see https://regex101.com/r/tI7pK1/3
     * @param string $content
     */
    public static function encode($content)
    {
        preg_match_all(static::REGEX, $content, $results, PREG_SET_ORDER);
        
        foreach($results as $row) {
            switch($row['function']) {
                case "link":
                    $replace = static::functionLink($row);
                    break;
                    
                case "file":
                    $replace = '';
                    break;
                default:
                    continue;
                    break;
            }
            $content = preg_replace('/'.preg_quote($row[0]).'/mi', $replace, $content, 1);
        }
        
        return $content;
    }
    
    public static function functionLink($result)
    {
        if (is_numeric($result['value'])) {
            $href = "## WIRD DURCH LINKS COMPONENT ERSETZT##";
        } else {
            $href = $result['value'];
        }
        
        if (isset($result['sub'])) {
            $label = $result['sub'];
        } else {
            $label = $result['value'];
        }
        return '<a href="'.$href.'">'.$label.'</a>';
    }
    
    public static function functionFile($result)
    {
        return;
    }
}