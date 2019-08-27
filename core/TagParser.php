<?php

namespace luya;

use Yii;
use luya\tag\TagMarkdownParser;
use yii\base\BaseObject;

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
 * @since 1.0.0
 */
class TagParser extends BaseObject
{
    /**
     * @var string Base regular expression to determine function, values and value-sub informations.
     * @see https://regex101.com/r/hP9nJ1/1 - Online Regex tester
     */
    const REGEX = '/(?<function>[a-z]+)\[(?<value>.*?)\]((?<!\\\\)\((?<sub>.*?)(?<!\\\\)\))?/mi';
    
    private $tags = [
        'mail' => ['class' => 'luya\tag\tags\MailTag'],
        'tel' => ['class' => 'luya\tag\tags\TelTag'],
        'link' => ['class' => 'luya\tag\tags\LinkTag'],
    ];
    
    private static $_instance;
    
    /**
     * Inject a new tag with a given name and a configurable array config.
     *
     * @param string $name The name of the tag on what the tag should be found. Must be [a-z] chars.
     * @param string|array $config The configurable object context can be either a string with a class or a configurable array base on {{yii\base\BaseObject}} concept.
     */
    public static function inject($name, $config)
    {
        self::getInstance()->addTag($name, $config);
    }
    
    /**
     * Convert the CMS-Tags into HTML-Tags.
     *
     * @param string $text The content where the CMS-Tags should be found and convert into Html-Tags.
     * @return string The converted output of $text.
     */
    public static function convert($text)
    {
        return self::getInstance()->processText($text);
    }
    
    /**
     * Convert the CMS-Tags into HTMl-Tags and additional convert GFM Markdown into Html as well. The main purpose
     * of this method to fix the conflict between markdown and tag parser when using urls.
     *
     * @param string $text The content where the CMS-Tags should be found and convert into Html-Tags and Markdown Tags.
     * @return string the Converted output of $text.
     */
    public static function convertWithMarkdown($text)
    {
        return (new TagMarkdownParser())->parse(static::convert($text));
    }
    
    /**
     * Generate the instance for all registered tags.
     *
     * The main purpose of this method is to return all tag objects in admin context to provide help informations from the tags.
     *
     * @return \luya\tag\TagInterface
     */
    public static function getInstantiatedTagObjects()
    {
        $context = self::getInstance();
        foreach ($context->tags as $key => $config) {
            $context->instantiatTag($key);
        }
        
        return $context->tags;
    }
    
    /**
     * Get the TagParser object, create new if not exists
     *
     * @return static
     */
    private static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
    
        return self::$_instance;
    }
    
    /**
     * Internal method to add a tag into the tags array.
     */
    private function addTag($identifier, $tagObjectConfig)
    {
        $this->tags[$identifier] = $tagObjectConfig;
    }

    /**
     * Check if the given tag name exists.
     *
     * @return boolean
     */
    private function hasTag($tag)
    {
        return isset($this->tags[$tag]);
    }

    /**
     * Create the tag instance (object) for a given tag name.
     */
    private function instantiatTag($tag)
    {
        if (!is_object($this->tags[$tag])) {
            $this->tags[$tag] = Yii::createObject($this->tags[$tag]);
            Yii::trace('tag parser object generated for:'. $tag, __CLASS__);
        }
    }
    
    /**
     * Parse the given tag with context informations.
     *
     * @return string Returns the parsed tag value.
     */
    private function parseTag($tag, $context)
    {
        // ensure tag is an object
        $this->instantiatTag($tag);
        // extract context
        $value = isset($context['value']) ? $context['value'] : false;
        $sub = isset($context['sub']) ? $context['sub'] : false;
        // the sub value can contain escaped values, those values must be parsed back into the original state.
        if ($sub) {
            $sub = str_replace(['\)', '\('], [')', '('], $sub);
        }
        // run parse method inside the tag object.
        return $this->tags[$tag]->parse($value, $sub);
    }

    /**
     * Process a given text.
     *
     * + This will find all tag based expressions inside the text
     * + instantiate the tag if the alias exists.
     * + parse the tag and modify the input $text
     *
     * @param string $text The input text
     * @return string The parsed text
     */
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
            // extract tag name from regex
            $tag = $row['function'];
            if ($this->hasTag($tag)) {
                $replace = $this->parseTag($tag, $row);
                $text = preg_replace('/'.preg_quote($row[0], '/').'/mi', $replace, $text, 1);
            }
        }
        
        return $text;
    }
}
