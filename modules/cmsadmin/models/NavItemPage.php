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
            [['text'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['layout_id'],
            'restupdate' => ['layout_id']
        ];
    }

    public function getContent()
    {
        $loader = new \Twig_Loader_Filesystem(yii::getAlias('@cmsadmin').'/views');
        $twig = new \Twig_Environment($loader, ['autoescape' => false]);

        $insertion = [];

        foreach ($this->layout->getJsonConfig('placeholders') as $item) {
            $insertion[$item['var']] = $this->renderPlaceholder($this->id, $item['var'], 0);
        }

        return $twig->render($this->layout->view_file, array(
            "placeholders" => $insertion,
        ));
    }

    public function renderPlaceholder($navItemPageId, $placeholderVar, $prevId)
    {
        $string = '';

        $placeholders = (new \yii\db\Query())->from("cms_nav_item_page_block_item t1")->select("t1.*, t2.json_config, t2.twig_frontend")->leftJoin('cms_block t2', 't2.id = t1.block_id')->where(['nav_item_page_id' => $navItemPageId, 'placeholder_var' => $placeholderVar, 'prev_id' => $prevId])->all();

        foreach ($placeholders as $key => $placeholder) {
            $loader = new \Twig_Loader_String();

            $twig = new \Twig_Environment($loader, ['autoescape' => false]);

            $configValues = json_decode($placeholder['json_config_values'], true);

            if (!empty($configValues)) {
                $configValues = [];
            }

            $jsonConfig = json_decode($placeholder['json_config'], true);

            $insertedHolders = [];

            if (isset($jsonConfig['placeholders'])) {
                foreach ($jsonConfig['placeholders'] as $item) {
                    $insertedHolders[$item['var']] = $this->renderPlaceholder($navItemPageId, $item['var'], $placeholder['id']);
                }

                $configValues['placeholders'] = $insertedHolders;
            }

            $string .= $twig->render($placeholder['twig_frontend'], $configValues);
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
