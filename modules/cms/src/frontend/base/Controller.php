<?php

namespace luya\cms\frontend\base;

use Yii;
use luya\web\View;
use luya\TagParser;
use luya\cms\models\NavItem;
use yii\web\NotFoundHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use luya\cms\frontend\events\BeforeRenderEvent;
use luya\helpers\StringHelper;

/**
 * Abstract Controller for CMS Controllers.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class Controller extends \luya\web\Controller
{
    /**
     * Render the NavItem content and set several view specific data.
     *
     * @param integer $navItemId
     * @param string $appendix
     * @param boolean|integer $setNavItemTypeId To get the content of a version this parameter will change the database value from the nav item Model
     * to this provided value
     *
     * @return string
     * @throws NotFoundHttpException
     * @throws MethodNotAllowedHttpException
     */
    public function renderItem($navItemId, $appendix = null, $setNavItemTypeId = false)
    {
        $model = NavItem::find()->where(['id' => $navItemId])->with(['nav'])->one();

        if (!$model) {
            throw new NotFoundHttpException('The requested nav item could not found.');
        }

        Yii::$app->urlManager->contextNavItemId = $navItemId;
        
        $currentMenu = Yii::$app->menu->current;
        
        $event = new BeforeRenderEvent();
        $event->menu = $currentMenu;
        foreach ($model->nav->properties as $property) {
            $object = $property->getObject();
            
            $object->trigger($object::EVENT_BEFORE_RENDER, $event);
            if (!$event->isValid) {
                throw new MethodNotAllowedHttpException('Your are not allowed to see this page.');
                return Yii::$app->end();
            }
        }
        
        if ($setNavItemTypeId !== false && !empty($setNavItemTypeId)) {
            $model->nav_item_type_id = $setNavItemTypeId;
        }
        
        $typeModel = $model->getType();
       
        if (!$typeModel) {
            throw new NotFoundHttpException("The requestd nav item could not be found with the paired type, maybe this version does not exists for this Type.");
        }
        
        $typeModel->setOptions([
            'navItemId' => $navItemId,
            'restString' => $appendix,
        ]);
        
        $content = $typeModel->getContent();
        
        
        if ($content instanceof Response) {
            return Yii::$app->end(0, $content);
        }
        
        // it seems to be a json response as it is an array
        if (is_array($content)) {
            return $content;
        }

        // https://github.com/luyadev/luya/issues/863 - if context controller is not false and the layout variable is not empty, the layout file will be displayed
        // as its already renderd by the module controller itself.
        if ($typeModel->controller !== false && !empty($typeModel->controller->layout)) {
            $this->layout = false;
        }
        
        // If the user has defined a layout file, thise will be ensured and set as layout file.
        $layoutFile = $model->nav->layout_file;
        if (!empty($layoutFile)) {
            $this->layout = StringHelper::startsWith($layoutFile, '@') ? $layoutFile : '/' . ltrim($layoutFile, '/');
        }
        
        if ($this->view->title === null) {
            if (empty($model->title_tag)) {
                $this->view->title = $model->title;
            } else {
                $this->view->title = $model->title_tag;
            }
        }
        
        $this->view->registerMetaTag(['name' => 'og:title', 'content' => $this->view->title], 'fbTitle');
        $this->view->registerMetaTag(['name' => 'og:type', 'content' => 'website'], 'ogType');
        
        
        if (!empty($model->description)) {
            $this->view->registerMetaTag(['name' => 'description', 'content' => $model->description], 'metaDescription');
            $this->view->registerMetaTag(['name' => 'og:description', 'content' => $model->description], 'fbDescription');
        }
        
        if (!empty($model->keywords)) {
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => implode(", ", $currentMenu->keywords)], 'metyKeywords');
        }
        
        if ($this->module->enableTagParsing) {
            $content = TagParser::convert($content);
        }
        
        if (Yii::$app->has('adminuser') && !Yii::$app->adminuser->isGuest && $this->module->overlayToolbar === true) {
            $this->view->registerCssFile('//fonts.googleapis.com/icon?family=Material+Icons');
            $this->getView()->on(View::EVENT_BEGIN_BODY, [$this, 'renderToolbar'], ['content' => $content]);
        }
        
        return $content;
    }
    
    public function renderToolbar($event)
    {
        Yii::info('LUYA CMS Toolbar rendering start', __METHOD__);
    
        $props = [];
        foreach (Yii::$app->menu->current->model->properties as $prop) {
            $o = $prop->getObject();
            $props[] = ['label' => $o->label(), 'value' => $o->getValue()];
        }
    
        $menu = Yii::$app->menu;
    
        // seo keyword frequency
        $seoAlert = 0;
        $keywords = [];
        $content = strip_tags($event->data['content']);
    
        if (empty($menu->current->description)) {
            $seoAlert++;
        }
    
        if (empty($menu->current->keywords)) {
            $seoAlert++;
        } else {
            foreach ($menu->current->keywords as $word) {
                if (preg_match_all('/' . preg_quote($word, '/') . '/i', $content, $matches)) {
                    $keywords[] = [$word, count($matches[0])];
                } else {
                    $keywords[] = [$word, 0];
                    $seoAlert++;
                }
            }
        }
        
        // echo is used in order to support cases where asset manager is not available
        echo '<style>' . $this->renderPartial('/inline/toolbar.css') . '</style>';
        // mabye ensure that jquery is loaded,  better put this at the End of body tag
        echo '<script>' . $this->renderPartial('/inline/toolbar.js') . '</script>';
    
        echo $this->renderPartial('/_toolbar.php', [
            'keywords' => $keywords,
            'seoAlertCount' => $seoAlert,
            'menu' => $menu,
            'composition' => Yii::$app->composition,
            'luyaTagParsing' => $event->sender->context->module->enableTagParsing,
            'properties' => $props,
            'content' => $content,
        ]);
    
        Yii::info('LUYA CMS Toolbar rendering is finished', __METHOD__);
    }
}
