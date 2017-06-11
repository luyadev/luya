<?php

namespace luya\cms\injectors;

use luya\cms\base\BaseBlockInjector;
use luya\admin\base\TypesInterface;
use luya\cms\helpers\BlockHelper;
use luya\admin\models\Tag;
use luya\helpers\ArrayHelper;

/**
 * Tag Injector generates Checkbox with Admin-Tags.
 *
 * The Tag Injector provides a checkbox with all available tags from the administration area. You
 * can select tags and return those selected tags in order to furter process your data (then you should
 * access the {{\luya\cms\injectors\TagInjector::getAssignedTags}} method trough the ArrayAccess Api
 * of the Block.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class TagInjector extends BaseBlockInjector
{
    /**
     * Returns all avialable Tags.
     *
     * @return \luya\admin\models\Tag Tag Model ActiveQuery.
     */
    public function getCheckboxArray()
    {
        return Tag::find()->select(['name'])->indexBy('id')->column();
    }
    
    private $_assignedTags;
    
    /**
     * Get assigned models for the current Block.
     *
     * @return \luya\admin\models\Tag All selected tags within the tag model.
     */
    public function getAssignedTags()
    {
        if ($this->_assignedTags === null) {
            $ids = ArrayHelper::getColumn($this->getContextConfigValue($this->varName, []), 'value');
            $this->_assignedTags = Tag::find()->where(['in','id', $ids])->indexBy('name')->all();
        }
        
        return $this->_assignedTags;
    }
    
    /**
     * @inheritdoc
     */
    public function setup()
    {
        $this->setContextConfig([
            'var' => $this->varName,
            'type' => TypesInterface::TYPE_CHECKBOX_ARRAY,
            'label' => $this->varLabel,
            'options' => BlockHelper::checkboxArrayOption($this->getCheckboxArray()),
        ]);
        
        $this->context->addExtraVar($this->varName, $this->getAssignedTags());
    }
}
