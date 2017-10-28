<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;
use luya\cms\helpers\BlockHelper;

/**
 * Internal or External Link Plugin.
 *
 * In order to use this plugin the {{luya\cms\admin\Module}} is required in your application.
 *
 * Its recommend to use the type varchar for the field where the Link plugin is applied.
 *
 * The value of the field is a {{luya\web\LinkInterface}} there for you can access the `getHref` and `getTarget` methods in order to generate the link:
 *
 * ```php
 * <a href="<?= $model->link->getHref(); ?>" target="<?= $model->link->getTarget(); ?>>">Go There</a>
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Link extends Plugin
{
    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }
    
    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-link', $id, $ngModel);
    }
    
    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->createFormTag('zaa-link', $id, $ngModel);
    }
    
    /**
     * @inheritdoc
     */
    public function onBeforeSave($event)
    {
        // if its not i18n casted field we have to serialize the the file array as json and abort further event excution.
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->i18nFieldEncode($event->sender->getAttribute($this->name)));
            return false;
        }
    
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function onBeforeExpandFind($event)
    {
        if (!$this->i18n) {
            $event->sender->setAttribute($this->name, $this->jsonDecode($event->sender->getAttribute($this->name)));
            return false;
        }
         
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function onBeforeFind($event)
    {
        if (!$this->i18n) {
            $value = $this->jsonDecode($event->sender->getAttribute($this->name));
            $event->sender->setAttribute($this->name, $this->generateLinkObject($value));
            return false;
        }
    
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function onAfterFind($event)
    {
        $event->sender->setAttribute($this->name, $this->generateLinkObject($event->sender->getAttribute($this->name)));
    }

    /**
     * Generate the link object from the given database array value.
     *
     * @param array $config The configuration array must contain the keys `value` and `type`.
     * @return string The parsed link source based on the input type.
     */
    protected function generateLinkObject($config)
    {
        return BlockHelper::linkObject($config);
    }
}
