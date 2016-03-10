<?php

namespace luya\web;

use Yii;
use luya\helpers\Url;

/**
 * LUYA web view wrapper
 * 
 * @author nadar
 */
class View extends \yii\web\View
{
    private $_publicHtml = null;
    
    /**
     * @var boolean If csrf validation is enabled in the request component, and autoRegisterCsrf is enabled, then
     * all the meta informations will be auto added to meta tags.
     */
    public $autoRegisterCsrf = true;
    
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
     * @todo verify there is already a yii-way solution
     *
     * @param string $assetName
     *
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
     *
     * @return string compressed string
     */
    public function compress($content)
    {
        return preg_replace(array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s'), array('>', '<', '\\1'), $content);
    }

    /**
     * Helper method for convenience.
     *
     * @param string $route
     * @param array  $params
     *
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
        if ($this->_publicHtml === null) {
            $this->_publicHtml = Yii::$app->request->baseUrl;
        }
        
        return $this->_publicHtml;
    }
}
