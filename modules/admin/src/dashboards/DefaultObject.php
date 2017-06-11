<?php

namespace luya\admin\dashboards;

use Yii;
use yii\helpers\Html;
use luya\helpers\ArrayHelper;

/**
 * Fast generated Dashboard Objects.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class DefaultObject extends BaseDashboardObject
{
    /**
     * @var array Options to generate the wrapper element. Generates a tag like:
     * 
     * ```
     * <div class="card-panel" ng-controller="DefaultDashboardObjectController" ng-init="loadData(\'{{dataApiUrl}}\');">
     *     <!-- content from: $outerTemplate -->
     * </div>
     * ```
     */
    public $wrapperOptions = [
        'class' => 'card-panel',
        'ng-controller' => 'DefaultDashboardObjectController',
        'ng-init' => 'loadData(\'{{dataApiUrl}}\')',
    ];
    
	/**
	 * @var string The wrapper template which is by default:
	 * 
	 * ```
	 * <h3>{{title}}</h3>{{template}}
	 * ```
	 */
    public $outerTemplate = '<h3>{{title}}</h3>{{template}}';

    public function getTitle()
    {
        $title = parent::getTitle();
        
        if (!is_array($title)) {
            return $title;
        }
        
        list($category, $message) = $title;
        
        return Yii::t($category, $message);
    }
    
    /**
     * @inheritdoc
     */
    public function getTemplate()
    {
        $template = parent::getTemplate();
        
        $wrapper = Html::tag(ArrayHelper::remove($this->wrapperOptions, 'tag', 'div'), $this->outerTemplate, $this->wrapperOptions);
        
        return str_replace(['{{dataApiUrl}}', '{{title}}', '{{template}}'], [$this->getDataApiUrl(), $this->getTitle(), $template], $wrapper);
    }
}