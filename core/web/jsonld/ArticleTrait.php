<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Article Trait
 *
 * @see http://schema.org/Article
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
trait ArticleTrait
{
    use CreativeWorkTrait;

    /**
     * The actual body of the article.
     *
     * @var string
     */
    private $_articleBody;

    /**
     * @return string
     */
    public function getArticleBody()
    {
        return $this->_articleBody;
    }

    /**
     * @param string $articleBody
     * @return Article|ArticleTrait
     */
    public function setArticleBody($articleBody)
    {
        $this->_articleBody = $articleBody;
        return $this;
    }

    /**
     * Articles may belong to one or more 'sections' in a magazine or newspaper, such as Sports, Lifestyle, etc.
     *
     * @var string
     */
    private $_articleSection;

    /**
     * @return string
     */
    public function getArticleSection()
    {
        return $this->_articleSection;
    }

    /**
     * @param string $articleSection
     * @return Article|ArticleTrait
     */
    public function setArticleSection($articleSection)
    {
        $this->_articleSection = $articleSection;
        return $this;
    }

    /**
     * The page on which the work ends; for example "138" or "xvi".
     *
     * @var int|string
     */
    private $_pageEnd;

    /**
     * @return int|string
     */
    public function getPageEnd()
    {
        return $this->_pageEnd;
    }

    /**
     * @param int|string $pageEnd
     * @return Article|ArticleTrait
     */
    public function setPageEnd($pageEnd)
    {
        $this->_pageEnd = $pageEnd;
        return $this;
    }

    /**
     * The page on which the work starts; for example "135" or "xiii".
     *
     * @var int|string
     */
    private $_pageStart;

    /**
     * @return int|string
     */
    public function getPageStart()
    {
        return $this->_pageStart;
    }

    /**
     * @param int|string $pageStart
     * @return Article|ArticleTrait
     */
    public function setPageStart($pageStart)
    {
        $this->_pageStart = $pageStart;
        return $this;
    }

    /**
     * Any description of pages that is not separated into pageStart and pageEnd;
     * for example, "1-6, 9, 55" or "10-12, 46-49".
     *
     * @var string
     */
    private $_pagination;

    /**
     * @return string
     */
    public function getPagination()
    {
        return $this->_pagination;
    }

    /**
     * @param string $pagination
     * @return Article|ArticleTrait
     */
    public function setPagination($pagination)
    {
        $this->_pagination = $pagination;
        return $this;
    }

    /**
     * Indicates sections of a Web page that are particularly 'speakable' in the sense of being highlighted as being
     * especially appropriate for text-to-speech conversion. Other sections of a page may also be usefully spoken in
     * particular circumstances; the 'speakable' property serves to indicate the parts most likely
     * to be generally useful for speech.
     *
     * The speakable property can be repeated an arbitrary number of times,
     * with three kinds of possible 'content-locator' values:
     *
     * 1.) id-value URL references - uses id-value of an element in the page being annotated. The simplest use
     * of speakable has (potentially relative) URL values, referencing identified sections of the document concerned.
     *
     * 2.) CSS Selectors - addresses content in the annotated page, eg. via class attribute. Use the cssSelector property.
     *
     * 3.) XPaths - addresses content via XPaths (assuming an XML view of the content). Use the xpath property.
     *
     * For more sophisticated markup of speakable sections beyond simple ID references, either CSS selectors
     * or XPath expressions to pick out document section(s) as speakable. For this we define a supporting type,
     * SpeakableSpecification which is defined to be a possible value of the speakable property.
     *
     * @var SpeakableSpecification|URL
     */
    private $_speakable;

    /**
     * @return SpeakableSpecification|URL
     */
    public function getSpeakable()
    {
        return $this->_speakable;
    }

    /**
     * @param SpeakableSpecification|URL $speakable
     * @return Article|ArticleTrait
     */
    public function setSpeakable($speakable)
    {
        $this->_speakable = $speakable;
        return $this;
    }

    /**
     * The number of words in the text of the Article.
     *
     * @var int
     */
    private $_wordCount;

    /**
     * @return int
     */
    public function getWordCount()
    {
        return $this->_wordCount;
    }

    /**
     * @param int $wordCount
     * @return Article|ArticleTrait
     */
    public function setWordCount($wordCount)
    {
        $this->_wordCount = $wordCount;
        return $this;
    }
}