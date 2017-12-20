<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Article
 *
 * An article, such as a news article or piece of investigative report.
 * Newspapers and magazines have articles of many different types and this is intended to cover them all.
 *
 * @see http://schema.org/Article
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
class Article extends BaseThing implements ArticleInterface
{
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'Article';
    }

    use ArticleTrait;
}