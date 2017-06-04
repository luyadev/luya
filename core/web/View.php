<?php

namespace luya\web;

use Yii;

use luya\Exception;

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
    public $autoRegisterCsrf = true;
    
    /**
     * Init view object. Implements auto register csrf meta tokens.
     * @see \yii\base\View::init()
     */
    public function init()
    {
        // call parent initializer
        parent::init();
        // auto register csrf tags if enabled
        if ($this->autoRegisterCsrf && Yii::$app->request->enableCsrfValidation) {
            $this->registerMetaTag(['name' => 'csrf-param', 'content' => Yii::$app->request->csrfParam], 'csrfParam');
            $this->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::$app->request->getCsrfToken()], 'csrfToken');
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
        return preg_replace(['/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s'], ['>', '<', '\\1'], $content);
    }

    /**
     * Generate urls helper method.
     *
     * Helper method for convenience which is equal to {{luya\web\UrlManager::createUrl}}.
     *
     * @param string $route The route to create `module/controller/action`.
     * @param array $params Optional parameters passed as key value pairing.
     * @param boolean $scheme Whether to return static url or not
     * @deprecated Deprecated since 1.0.0-RC3 use {{luya\helpers\Url::toRoute}} instead. Will be removed in 1.0.0
     * @return string
     */
    public function url($route, array $params = [], $scheme = false)
    {
        trigger_error('Deprecated since 1.0.0-RC3 use \luya\helpers\Url::toRoute instead. Will be removed in 1.0.0', E_USER_DEPRECATED);
        $routeParams = [$route];
        foreach ($params as $key => $value) {
            $routeParams[$key] = $value;
        }
        
        if ($scheme) {
            return Yii::$app->urlManager->createAbsoluteUrl($routeParams);
        }
        
        return Yii::$app->urlManager->createUrl($routeParams);
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
