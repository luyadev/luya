<?php

namespace luya;

use Yii;
use yii\base\Object;
use luya\Exception;
use luya\tag\TagMarkdownParser;

class TagParser extends Object
{
    /**
     * @var string Base regular expression to determine function, values and value-sub informations.
     * @see https://regex101.com/r/hP9nJ1/1 - Online Regex tester
     */
    const REGEX = '/(?<function>[a-z]+)\[(?<value>.*?)\](\((?<sub>.*?)\))?/mi';
    
    private static $_instance = null;
    
    private static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        
        return self::$_instance;
    }
    
    public static function inject($name, $config)
    {
        static::getInstance()->addTag($name, $config);
    }
    
    public static function convert($text)
    {
        return static::getInstance()->processText($text);
    }
    
    public static function convertWithMarkdown($text)
    {
        return (new TagMarkdownParser())->parse(static::convert($text));
    }
    
    private $tags = [
        'mail' => ['class' => 'luya\tag\tags\MailTag'],
    ];
    
    private function addTag($identifier, $tagObjectConfig)
    {
        $this->tags[$identifier] = $tagObjectConfig;
    }

    private function hasTag($tag)
    {
        return isset($this->tags[$tag]);
    }

    private function evalTag($tag, $context)
    {
        if (!$this->hasTag($tag)) {
            throw new Exception("Wowo tag not found!");
        }
        
        if (!is_object($this->tags[$tag])) {
            $this->tags[$tag] = Yii::createObject($this->tags[$tag]);
            Yii::trace('tag parser object generated for:'. $tag, __CLASS__);
        }
        
        $value = isset($context['value']) ? $context['value'] : false;
        $sub = isset($context['sub']) ? $context['sub'] : false;
     
        
        return $this->tags[$tag]->parse($value, $sub);
    }

    private function processText($text)
    {
        // verify if content is a string otherwhise just return the original provided content
        if (!is_string($text) || empty($text)) {
            return $text;
        }
        // find all tags based on the REGEX expression
        preg_match_all(static::REGEX, $text, $results, PREG_SET_ORDER);
        // foreach all the results matches the regex
        foreach ($results as $row) {
            // When value is empty (can be caused by using `link[]` we have to skip this item.
            if (empty($row['value'])) {
                continue;
            }
            
            $tag = $row['function'];
            if ($this->hasTag($tag)) {
                $replace = $this->evalTag($tag, $row);
                $text = preg_replace('['.preg_quote($row[0]).']mi', $replace, $text, 1);
            }
        }
        
        return $text;
    }
}