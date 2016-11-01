<?php

namespace luya;

use Yii;
use yii\base\Object;
use luya\Exception;
use luya\tag\TagMarkdownParser;

/**
 * TagParser allows you to inject Tags and parse them.
 *
 * This is an additional concept to markdown, where you can inject your custom tags to parse. All tags must be an instance
 * of `luya\tag\BaseTag` and implement the `parse($value, $sub)` method in order to convert the input to your tag.
 *
 * Read more in the Guide [[concept-tags.md]].
 *
 * The identifier of the tag is not related to your tag, so you can configure the same tag as different names with multiple
 * purposes.
 *
 * To inject a created tag just use:
 *
 * ```php
 * TagParser::inject('tagname', ['class' => 'path\to\TagClass']);
 * ```
 *
 * To parse text with or without markdown use:
 *
 * ```php
 * TagParser::convert('Hello tagname[value](sub)');
 * TagParser::convertWithMarkdown('**Hello** tagname[value](sub)');
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-rc1
 */
class TagParser extends Object
{
    /**
     * @var string Base regular expression to determine function, values and value-sub informations.
     * @see https://regex101.com/r/hP9nJ1/1 - Online Regex tester
     */
    const REGEX = '/(?<function>[a-z]+)\[(?<value>.*?)\](\((?<sub>.*?)\))?/mi';
    
    private $tags = [
        'mail' => ['class' => 'luya\tag\tags\MailTag'],
        'tel' => ['class' => 'luya\tag\tags\TelTag'],
        'link' => ['class' => 'luya\tag\tags\LinkTag'],
    ];
    
    private static $_instance = null;
    
    /**
     * Inject a new tag with a given name and a configurable array config.
     *
     * @param string $name The name of the tag on what the tag should be found. Must be [a-z] chars.
     * @param string|array $config The configurable object context can be either a string with a class or a configurable array base on yii\base\Object concept.
     */
    public static function inject($name, $config)
    {
        static::getInstance()->addTag($name, $config);
    }
    
    /**
     * Convert the CMS-Tags into HTML-Tags.
     *
     * @param string $text The content where the CMS-Tags should be found and convert into Html-Tags.
     * @return string The converted output of $text.
     */
    public static function convert($text)
    {
        return static::getInstance()->processText($text);
    }
    
    /**
     * Convert the CMS-Tags into HTMl-Tags and additional convert GFM Markdown into Html as well. The main purpose
     * of this method to fix the conflict between markdown and tag parser when using urls.
     *
     * @param string $text The content where the CMS-Tags should be found and convert into Html-Tags and Markdown Tags.
     * @return string the COnverted output of $text.
     */
    public static function convertWithMarkdown($text)
    {
        return (new TagMarkdownParser())->parse(static::convert($text));
    }
    
    public static function getInstantiatedTagObjects()
    {
        $context = static::getInstance();
        foreach ($context->tags as $key => $config) {
            $context->instantiatTag($key);
        }
        
        return $context->tags;
    }
    
    private static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
    
        return self::$_instance;
    }
    
    private function addTag($identifier, $tagObjectConfig)
    {
        $this->tags[$identifier] = $tagObjectConfig;
    }

    private function hasTag($tag)
    {
        return isset($this->tags[$tag]);
    }

    private function instantiatTag($tag)
    {
        if (!$this->hasTag($tag)) {
            throw new Exception("Unable to find requested TagParser tag '{$tag}'.");
        }
        
        if (!is_object($this->tags[$tag])) {
            $this->tags[$tag] = Yii::createObject($this->tags[$tag]);
            Yii::trace('tag parser object generated for:'. $tag, __CLASS__);
        }
    }
    
    private function evalTag($tag, $context)
    {
        $this->instantiatTag($tag);
        
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
