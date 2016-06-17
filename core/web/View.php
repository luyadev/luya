<?php

namespace luya\web;

use Yii;
use luya\helpers\Url;

/**
 * LUYA web view wrapper.
 * 
 * Implements additional helper methods to the Yii web controller.
 * 
 * @author Basil Suter <basil@nadar.io>
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
     * @todo verify there is already a yii-way solution
     * @param string $assetName
     * @return string
     */
    public function getAssetUrl($assetName)
    {
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
     * @param string $route The route to create `module/controller/action`.
     * @param array $params Optional parameters passed as key value pairing.
     * @return string
     */
    public function url($route, array $params = [])
    {
        return Url::toManager($route, $params);
    }
    
    /**
     * Return the relativ path to your public_html folder.
     *
     * This wrapper function is commonly used to get the path for images or other files inside your
     * public_html directory. For instance you have put some images in our public folder `public_html/img/luya.png`
     * then you can access the image file inside your view files with:
     *
     * ```
     * <img src="<?php echo $this->publicHtml; ?>/img/luya.png" />
     * ```
     *
     * There is also a twig variable providing the same value:
     *
     * ```
     * <img src="{{ publicHtml }}/img/luya.png" />
     * ```
     *
     * @return string The relative baseUrl to your public_html folder.
     */
    public function getPublicHtml()
    {
        return Yii::$app->request->baseUrl;
    }
}
