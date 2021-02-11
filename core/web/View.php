<?php

namespace luya\web;

use Yii;

use luya\Exception;
use luya\helpers\StringHelper;

/**
 * LUYA web view wrapper.
 *
 * Implements additional helper methods to the Yii web controller.
 *
 * @property string $publicHtml Return the relativ path to your public_html folder
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class View extends \yii\web\View
{
    /**
     * @var boolean If csrf validation is enabled in the request component, and autoRegisterCsrf is enabled, then
     * all the meta informations will be auto added to meta tags.
     */
    public $autoRegisterCsrf = false;
    
    /**
     * Init view object. Implements auto register csrf meta tokens.
     * @see \yii\base\View::init()
     */
    public function init()
    {
        // call parent initializer
        parent::init();

        if (empty($this->theme) && Yii::$app->themeManager->hasActiveTheme) {
            $this->theme = Yii::$app->themeManager->activeTheme;
        }

        // auto register csrf tags if enabled
        if ($this->autoRegisterCsrf && Yii::$app->request->enableCsrfValidation) {
            $this->registerCsrfMetaTags();
        }
    }

    /**
     * Get the url source for an asset.
     *
     * When registering an asset `\app\assets\ResoucesAsset::register($this)` the $assetName
     * is `app\assets\ResourcesAsset`.
     *
     * @param string $assetName The class name of the asset bundle (without the leading backslash)
     * @return string The internal base path to the asset file.
     * @throws Exception
     */
    public function getAssetUrl($assetName)
    {
        $assetName = ltrim($assetName, '\\');
        
        if (!isset($this->assetBundles[$assetName])) {
            throw new Exception("The AssetBundle '$assetName' is not registered.");
        }
        
        return $this->assetBundles[$assetName]->baseUrl;
    }

    /**
     * Removes redundant whitespaces (>1) and new lines (>1).
     *
     * @param string $content input string
     * @return string compressed string
     */
    public function compress($content)
    {
        return StringHelper::minify($content);
    }

    /**
     * Return the relativ path to your public_html folder.
     *
     * This wrapper function is commonly used to get the path for images or other files inside your
     * public_html directory. For instance you have put some images in our public folder `public_html/img/luya.png`
     * then you can access the image file inside your view files with:
     *
     * ```php
     * <img src="<?= $this->publicHtml; ?>/img/luya.png" />
     * ```
     *
     * @return string The relative baseUrl to your public_html folder.
     */
    public function getPublicHtml()
    {
        return Yii::$app->request->baseUrl;
    }
}
