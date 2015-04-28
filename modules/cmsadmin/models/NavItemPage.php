<?php
namespace cmsadmin\models;

use yii;

class NavItemPage extends \cmsadmin\base\NavItemType
{
    public static function tableName()
    {
        return 'cms_nav_item_page';
    }

    public function rules()
    {
        return [
            [['layout_id'], 'required'],
        ];
    }

    public function getContent()
    {
        $loader = new \Twig_Loader_Filesystem(\yii::getAlias('@app/views/cmslayouts/'));
        $twig = new \Twig_Environment($loader, ['autoescape' => false, 'debug' => true]);
        $twig->addExtension(new \Twig_Extension_Debug());
        $linksFunction = new \Twig_SimpleFunction('links', function($cat, $lang, $parent_nav_id) {
            return yii::$app->collection->links->findByArguments(['cat' => $cat, 'lang' => $lang, 'parent_nav_id' => $parent_nav_id ]);
        });
        $twig->addFunction($linksFunction);
        $insertion = [];

        foreach ($this->layout->getJsonConfig('placeholders') as $item) {
            $insertion[$item['var']] = $this->renderPlaceholder($this->id, $item['var'], 0);
        }

        return $twig->render($this->layout->view_file, [
            "placeholders" => $insertion,
            "activeLink" => \yii::$app->collection->links->getActiveLink()
        ]);
    }

    public function getContext()
    {
    }

    public function renderPlaceholder($navItemPageId, $placeholderVar, $prevId)
    {
        $string = '';

        $placeholders = (new \yii\db\Query())->from("cms_nav_item_page_block_item t1")->select("t1.*")->where(['nav_item_page_id' => $navItemPageId, 'placeholder_var' => $placeholderVar, 'prev_id' => $prevId])->orderBy('sort_index ASC')->all();

        foreach ($placeholders as $key => $placeholder) {
            $loader = new \Twig_Loader_String();
			// @todo disable debugging
            $twig = new \Twig_Environment($loader, ['autoescape' => false, 'debug' => true]);
            $twig->addExtension(new \Twig_Extension_Debug());
            $blockObject = \cmsadmin\models\Block::objectId($placeholder['block_id']);
            if ($blockObject === false) {
                continue;
            }
            $configValues = json_decode($placeholder['json_config_values'], true);
            $cfgValues = json_decode($placeholder['json_config_cfg_values'], true);

            if (empty($configValues)) {
                $configValues = [];
            }

            $blockObject->setVarValues($configValues);
            $jsonConfig = json_decode($blockObject->jsonConfig(), true);

            $insertedHolders = [];

            if (isset($jsonConfig['placeholders'])) {
                foreach ($jsonConfig['placeholders'] as $item) {
                    $insertedHolders[$item['var']] = $this->renderPlaceholder($navItemPageId, $item['var'], $placeholder['id']);
                }
            }
            $string .= $twig->render($blockObject->twigFrontend(), [
                'vars' => $configValues,
                'cfgs' => $cfgValues,
                'placeholders' => $insertedHolders,
                'extras' => $blockObject->extraVars(),
            ]);
        }

        return $string;
    }
    public function getHeaders()
    {
        return 'HEADERS!';
    }

    public function getLayout()
    {
        return $this->hasOne(\cmsadmin\models\Layout::className(), ['id' => 'layout_id']);
    }
}
