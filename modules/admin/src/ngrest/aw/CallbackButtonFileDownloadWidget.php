<?php

namespace luya\admin\ngrest\aw;

use luya\admin\ngrest\base\ActiveWindow;
use luya\admin\Module;
use luya\helpers\FileHelper;

/**
 * Callback Button which generates a file in the callback and displays the download button.
 *
 * In order to use this widget add the sendOutput method to your callback:
 *
 * ```php
 * public function callbackCreatepdf()
 * {
 *     // where content could be a pdf library for example:
 *     $pdf = new \FPDI();
 *	   $pdf->AddPage();
 *     $pdf->writeHTML('<p>Hello world!</p>', true, false, false, false, '');
 *     $content = $pdf->Output("Ticket-Rapport.pdf", "S");
 *
 *     return CallbackButtonFileDownloadWidget::sendOutput($this, 'Ticket-Report.pdf', $content);
 * }
 * ```
 *
 * then use the Widget in your ActiveWindow view:
 *
 * ```php
 * <?= CallbackButtonFileDownloadWidget::widget([
 *     'callback' => 'createpdf',
 *     'label' => 'Create PDF Report,
 * ]); ?>
 * ```
 *
 * In order to configure the second download button use:
 *
 * ```php
 * <?= CallbackButtonFileDownloadWidget::widget([
 *     'callback' => 'createpdf',
 *     'label' => 'Prepare PDF Report,
 *     'options' => [
 *     	    'class' => 'btn btn-download btn-icon'
 *	        'linkLabel' => 'Download Report',
 *			'linkClass' => 'btn btn-info',
 *	   ]
 * ]); ?>
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class CallbackButtonFileDownloadWidget extends CallbackButtonWidget
{
    /**
     * @inheritdoc
     */
    public $angularCallbackFunction = 'function($response, $scope) { $scope.linkHref = $response.url; $scope.linkHrefHidden = false; $scope.buttonHidden = true; };';
    
    /**
     * @inheritdoc
     */
    public $options = ['class' => 'btn btn-download btn-icon'];
    
    /**
     * Generates and returns the content output.
     *
     * @param \luya\admin\ngrest\base\ActiveWindow $context The ActiveWindow context where the method is called in order to act as the callback could.
     * @param string $fileName The filename which the the user would download. Make sure to use the correct extension as the mime type is read from the extension name.
     * @param string $content The output content which will be written to a temporary file and the return to the user by your filename.
     * @return array
     */
    public static function sendOutput(ActiveWindow $context, $fileName, $content)
    {
        $mimeType = FileHelper::getMimeTypeByExtension($fileName);
        
        $url = $context->createDownloadableFileUrl($fileName, $mimeType, $content);
        
        return $context->sendSuccess(Module::t('callback_button_file_download_widget_success'), ['url' => $url]);
    }
}
