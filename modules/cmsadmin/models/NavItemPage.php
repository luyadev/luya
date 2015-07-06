<?php

namespace cmsadmin\models;

use Yii;

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
        $twig = Yii::$app->twig->env(new \Twig_Loader_Filesystem(\yii::getAlias('@app/views/cmslayouts/')));

        $insertion = [];

        foreach ($this->layout->getJsonConfig('placeholders') as $item) {
            $insertion[$item['var']] = $this->renderPlaceholder($this->id, $item['var'], 0);
        }

        return $twig->render($this->layout->view_file, [
            'placeholders' => $insertion,
            'activeUrl' => Yii::$app->links->activeUrl,
        ]);
    }
    
    public function attributeLabels()
    {
        return [
            'layout_id' => 'Layout'  
        ];
    }

    public function renderPlaceholder($navItemPageId, $placeholderVar, $prevId)
    {
        $string = '';

        $placeholders = (new \yii\db\Query())->from('cms_nav_item_page_block_item t1')->select('t1.*')->where(['nav_item_page_id' => $navItemPageId, 'placeholder_var' => $placeholderVar, 'prev_id' => $prevId])->orderBy('sort_index ASC')->all();

        $twig = Yii::$app->twig->env(new \Twig_Loader_String());

        foreach ($placeholders as $key => $placeholder) {
            $blockObject = \cmsadmin\models\Block::objectId($placeholder['block_id']);
            if ($blockObject === false) {
                continue;
            }
            $configValues = json_decode($placeholder['json_config_values'], true);
            $cfgValues = json_decode($placeholder['json_config_cfg_values'], true);

            if (empty($configValues)) {
                $configValues = [];
            }

            if (empty($cfgValues)) {
                $cfgValues = [];
            }

            foreach($this->getOptions() as $optKey => $optValue) {
                $blockObject->setEnvOption($optKey, $optValue);
            }
            $blockObject->setVarValues($configValues);
            $blockObject->setCfgValues($cfgValues);

            $jsonConfig = json_decode($blockObject->jsonConfig(), true);

            $insertedHolders = [];

            if (isset($jsonConfig['placeholders'])) {
                foreach ($jsonConfig['placeholders'] as $item) {
                    $insertedHolders[$item['var']] = $this->renderPlaceholder($navItemPageId, $item['var'], $placeholder['id']);
                }
            }
            $string .= $twig->render($blockObject->getTwigFrontendContent(), [
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
