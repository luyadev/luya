<?php

namespace admintests\admin\ngrest\aw;

use admintests\AdminTestCase;
use luya\admin\ngrest\aw\CallbackButtonWidget;
use yii\base\Widget;

class CallbackButtonWidgetTest extends  AdminTestCase
{
    public function testRenderOutput()
    {
        $html = CallbackButtonWidget::widget(['label' => 'label', 'callback' => 'cb', 'params' => ['foo' => 'bar']]);
        
        $out = <<<'EOT'
<script>zaa.bootstrap.register('ControllerLabelCb', function($scope, $controller) { $scope.crud = $scope.$parent; $scope.sendButton = function(callback, params) { $scope.crud.sendActiveWindowCallback(callback, params).then(function(success) { var data = success.data; var errorType = null; var message = false; if ("error" in data) { errorType = data.error; } if ("message" in data) { message = data.message; } if (errorType !== null) { if (errorType == true) { $scope.crud.toast.error(message, 8000); } else { $scope.crud.toast.success(message, 8000); } } }, function(error) { $scope.crud.toast.error(error.data.message, 8000); }); }; });</script><div ng-controller="ControllerLabelCb"><button ng-click='sendButton("cb", {"foo":"bar"})' class="btn" type="button">label</button></div>
EOT;
        $this->assertSame($out, $this->removeNewline($html));
    }
    
    public function testRenderOutputNoParams()
    {
        $html = CallbackButtonWidget::widget(['label' => 'label', 'callback' => 'cb']);
    
        $this->assertContains('sendButton("cb", [])', $html);
    }
}