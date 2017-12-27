<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Article Interface
 *
 * @see http://schema.org/Article
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
interface ArticleInterface extends CreativeWorkInterface
{
    /**
     * @return string
     */
    public function getArticleBody();

    /**
     * @param string $articleBody
     */
    public function setArticleBody($articleBody);

    /**
     * @return string
     */
    public function getArticleSection();

    /**
     * @param string $articleSection
     */
    public function setArticleSection($articleSection);

    /**
     * @return int|string
     */
    public function getPageEnd();

    /**
     * @param int|string $pageEnd
     */
    public function setPageEnd($pageEnd);

    /**
     * @return int|string
     */
    public function getPageStart();

    /**
     * @param int|string $pageStart
     */
    public function setPageStart($pageStart);

    /**
     * @return string
     */
    public function getPagination();

    /**
     * @param string $pagination
     */
    public function setPagination($pagination);

    /**
     * @return SpeakableSpecification|URL
     */
    public function getSpeakable();

    /**
     * @param SpeakableSpecification|URL $speakable
     */
    public function setSpeakable($speakable);

    /**
     * @return int
     */
    public function getWordCount();

    /**
     * @param int $wordCount
     */
    public function setWordCount($wordCount);
}