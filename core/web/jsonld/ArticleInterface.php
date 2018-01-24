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
     * @return \luya\web\jsonld\Article
     */
    public function setArticleBody($articleBody);

    /**
     * @return string
     */
    public function getArticleSection();

    /**
     * @param string $articleSection
     * @return \luya\web\jsonld\Article
     */
    public function setArticleSection($articleSection);

    /**
     * @return int|string
     */
    public function getPageEnd();

    /**
     * @param int|string $pageEnd
     * @return \luya\web\jsonld\Article
     */
    public function setPageEnd($pageEnd);

    /**
     * @return int|string
     */
    public function getPageStart();

    /**
     * @param int|string $pageStart
     * @return \luya\web\jsonld\Article
     */
    public function setPageStart($pageStart);

    /**
     * @return string
     */
    public function getPagination();

    /**
     * @param string $pagination
     * @return \luya\web\jsonld\Article
     */
    public function setPagination($pagination);


    /**
     * @return int
     */
    public function getWordCount();

    /**
     * @param int $wordCount
     * @return \luya\web\jsonld\Article
     */
    public function setWordCount($wordCount);
}
