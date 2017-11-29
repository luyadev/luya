<?php

namespace luya\admin\dashboard;

use Yii;
use luya\admin\base\DashboardObjectInterface;
use yii\base\BaseObject;

/**
 * Base Implementation of an Dashboard Object.
 *
 * This provides the setters and getters from the {{luya\admin\base\DashboardObjectInterface}}.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class BaseDashboardObject extends BaseObject implements DashboardObjectInterface
{
    /**
     * Get the Outer Template.
     *
     * The outer is mainly a wrapper which wraps the template. As the template is the input from the module property, it has to wrappe into a nice looking
     * crad panel by default. But this is only used when dealing with base dashboard implementation.
     *
     * @return string Returns the outer template string which can contain the {{template}} variable, but don't have to.
     */
    abstract public function getOuterTemplateContent();
    
    private $_template;
    
    public function setTemplate($template)
    {
        $this->_template = $template;
    }
    
    /**
     * @inheritdoc
     */
    public function getTemplate()
    {
        return $this->contentParser($this->getOuterTemplateContent());
    }

    public function contentParser($content)
    {
        return str_replace(['{{dataApiUrl}}', '{{title}}', '{{template}}'], [$this->getDataApiUrl(), $this->getTitle(), $this->_template], $content);
    }
    
    private $_dataApiUrl;
    
    public function setDataApiUrl($dataApiUrl)
    {
        $this->_dataApiUrl = $dataApiUrl;
    }
     
    /**
     * @inheritdoc
     */
    public function getDataApiUrl()
    {
        return $this->_dataApiUrl;
    }
    
    private $_title;
    
    /**
     * Setter method for title.
     *
     * The title can be either a string on array, if an array is provided the first key is used to defined the yii2 message category and second key
     * is used in order to find the message. For example the input array `['cmsadmin', 'mytitle']` would be converted to `Yii::t('cmsadmin', 'mytitle')`.
     *
     * @param string|array $title The title of the dashboard object item, if an array is given the first element is the translation category the second element the message.
     */
    public function setTitle($title)
    {
        if (is_array($title)) {
            list($category, $message) = $title;
            $this->_title =  Yii::t($category, $message);
        } else {
            $this->_title = $title;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->_title;
    }
}
