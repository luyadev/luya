<?php

namespace luya\base;

use Yii;

/**
 * DynamicModel extends from yii\base\Dynamic Model.
 *
 * Additional Dynamic Model to provide attribute labels and attribute hints.
 *
 * ```php
 * $model = new DynamicModel(['query']);
 * $model->setAttributeHints(['query' => 'Enter a search term in order to find articles.']);
 * $model->addRule(['query'], 'string');
 * $model->addRule(['query'], 'required');
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class DynamicModel extends \yii\base\DynamicModel
{
    /**
     * @var array An array with key value pairing where key is the attribute and value the label.
     * @since 1.0.15
     */
    public $_attributeHints = [];

    /**
     * Sets the attribute hints in a massive way.
     *
     * @param array $hints Array of attribute hints
     * @return $this
     * @since 2.1.0
     */
    public function setAttributeHints(array $hints)
    {
        $this->_attributeHints = $hints;
        return $this;
    }

    /**
     * Get all hints for backwards compatibility.
     *
     * @return array
     * @since 2.1.0
     */
    public function getAttributeHints()
    {
        return $this->_attributeHints;
    }

    /**
     * {@inheritDoc}
     */
    public function attributeHints()
    {
        $hints = [];
        foreach ($this->attributeHints as $key => $value) {
            $hints[$key] = Yii::t('app', $value);
        }

        return $hints;
    }
}
