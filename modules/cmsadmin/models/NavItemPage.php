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
            [['layout_id'], 'required']
        ];
    }

    public function getContent()
    {
        $loader = new \Twig_Loader_Filesystem(\yii::getAlias('@app/views/cmslayouts/'));
        $twig = new \Twig_Environment($loader, ['autoescape' => false]);

        $insertion = [];

        foreach ($this->layout->getJsonConfig('placeholders') as $item) {
            $insertion[$item['var']] = $this->renderPlaceholder($this->id, $item['var'], 0);
        }

        return $twig->render($this->layout->view_file, [
            "placeholders" => $insertion,
        ]);
    }

    public function getContext()
    {
    }

    public function renderPlaceholder($navItemPageId, $placeholderVar, $prevId)
    {
        $string = '';

        $placeholders = (new \yii\db\Query())->from("cms_nav_item_page_block_item t1")->select("t1.*")->where(['nav_item_page_id' => $navItemPageId, 'placeholder_var' => $placeholderVar, 'prev_id' => $prevId])->all();

        foreach ($placeholders as $key => $placeholder) {
            $loader = new \Twig_Loader_String();

            $twig = new \Twig_Environment($loader, ['autoescape' => false]);

            $blockObject = \cmsadmin\models\Block::objectId($placeholder['block_id']);
            
            $configValues = json_decode($placeholder['json_config_values'], true);

            if (empty($configValues)) {
                $configValues = [];
            }

            $jsonConfig = json_decode($blockObject->getJsonConfig(), true);

            $insertedHolders = [];

            if (isset($jsonConfig['placeholders'])) {
                foreach ($jsonConfig['placeholders'] as $item) {
                    $insertedHolders[$item['var']] = $this->renderPlaceholder($navItemPageId, $item['var'], $placeholder['id']);
                }
            }
            $string .= $twig->render($blockObject->getTwigFrontend(), [
                'vars' => $configValues,
                'placeholders' => $insertedHolders
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
