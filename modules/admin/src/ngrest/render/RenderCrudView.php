<?php

namespace luya\admin\ngrest\render;

use luya\web\View;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * The View renderer for RenderCrud class.
 *
 * @property \luya\admin\ngrest\render\RenderCrud $context
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class RenderCrudView extends View
{
    public function registerAngularControllerScript()
    {
        $config = [
            'apiListQueryString' => $this->context->apiQueryString('list'),
            'apiUpdateQueryString' => $this->context->apiQueryString('update'),
            'apiEndpoint' => $this->context->getApiEndpoint(),
            'list' => $this->context->getFields('list'),
            'create' => $this->context->getFields('create'),
            'update' => $this->context->getFields('update'),
            'ngrestConfigHash' => $this->context->getConfig()->getHash(),
            'activeWindowCallbackUrl' => $this->context->getApiEndpoint('active-window-callback'),
            'activeWindowRenderUrl' =>  $this->context->getApiEndpoint('active-window-render'),
            'pk' => $this->context->getConfig()->getPrimaryKey(),
            'inline' => $this->context->getIsInline(),
            'modelSelection' => $this->context->getModelSelection(),
            'orderBy' => $this->context->getOrderBy(),
            'tableName' => $this->context->getConfig()->getTableName(),
            'groupBy' => $this->context->getConfig()->getGroupByField() ? 1 : 0,
            'groupByField' => $this->context->getConfig()->getGroupByField() ? $this->context->getConfig()->getGroupByField() : '0',
            'filter' => '0',
            'pagerHiddenByAjaxSearch' => false,
            'fullSearchContainer' => false,
            'minLengthWarning' => false,
            'saveCallback' => $this->context->getConfig()->getOption('saveCallback') ? new JsExpression($this->context->getConfig()->getOption('saveCallback')) : false,
            'relationCall' => $this->context->getRelationCall(),
            'relations' => $this->context->getConfig()->getRelations(),
        ];
        
        $client = 'zaa.bootstrap.register(\''.$this->context->config->getHash().'\', function($scope, $controller) {
			$.extend(this, $controller(\'CrudController\', { $scope : $scope }));
			$scope.config = '.Json::htmlEncode($config).'
	    });';
        
        $this->registerJs($client, self::POS_BEGIN);
    }
}
