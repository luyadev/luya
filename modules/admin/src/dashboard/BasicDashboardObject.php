<?php

namespace luya\admin\dashboard;

use yii\helpers\Html;
use luya\helpers\ArrayHelper;

/**
 * Fast generated Dashboard Objects.
 *
 * The default object is the default class for all {{luya\admin\base\Module::$dashboardObjects}} items without a class defintion.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class BasicDashboardObject extends BaseDashboardObject
{
    /**
     * @var array Options to generate the wrapper element. Generates a tag like:
     *
     * ```
     * <div class="card-panel" ng-controller="DefaultDashboardObjectController" ng-init="loadData(\'{{dataApiUrl}}\');">
     *     <!-- content from: $outerTemplate -->
     * </div>
     * ```
     *
     * The tag element `<div>` can be changed by overriding the key `tag`.
     */
    public $wrapperOptions = [
        'class' => 'card',
        'tag' => 'div',
    ];
    
    /**
     * @var string The wrapper template which is by default:
     *
     * ```
     * <h3>{{title}}</h3>{{template}}
     * ```
     *
     * The variables
     *
     * + {{title}}
     * + {{template}}
     * + {{dataApiUrl}}
     *
     * Will be automatically parsed to its original input while rendering.
     */
    public $outerTemplate = '<div class="card-header">{{title}}</div><div class="card-body">{{template}}</div>';

    /**
     * @inheritdoc
     */
    public function getOuterTemplateContent()
    {
        $options = ArrayHelper::merge([
            'ng-controller' => 'DefaultDashboardObjectController',
            'ng-init' => 'loadData(\'{{dataApiUrl}}\')'], $this->wrapperOptions);
        
        return Html::tag(ArrayHelper::remove($this->wrapperOptions, 'tag', 'div'), $this->outerTemplate, $options);
    }
}
