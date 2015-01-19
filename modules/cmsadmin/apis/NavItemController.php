<?php
namespace cmsadmin\apis;

class NavItemController extends \admin\base\RestController
{
    /**
     * http://example.com/admin/api-cms-navitem/nav-lang-items?access-token=XXX&navId=A&langId=B
     *
     * @param  unknown_type      $navId
     * @param  unknown_type      $langId
     * @return multitype:unknown
     */
    public function actionNavLangItems($navId, $langId)
    {
        return \cmsadmin\models\NavItem::find()->where(['nav_id' => $navId, 'lang_id' => $langId])->all();
    }

    public function actionCreate()
    {
        $data = $_POST;
        
        $model = new \cmsadmin\models\NavItem();
        $model->attributes = $data;
        if ($model->validate()) {
            $entry = $model->save();
            return $entry;
        }
    }
    
    /**
     * returns all the PAGE type specific informations.
     *
     */
    public function actionTypePageContainer($navItemId)
    {
        $navItem = \cmsadmin\models\NavItem::findOne($navItemId);
        $type = $navItem->getType();
        $layout = \cmsadmin\models\Layout::findOne($type->layout_id);
        if (!empty($layout)) {
            $layout->json_config = json_decode($layout->json_config, true);
        }

        return [
            //'nav_item' => $navItem,
            'layout' => $layout,
            'type_container' => $type
        ];
    }

    /**
     * @todo do not use active record for such querys, cause they are not slim enough, change to simple dbQuery?
     * @param  unknown_type             $navItemPageId
     * @param  unknown_type             $placeholderVar
     * @return multitype:multitype:NULL unknown
     */
    public function actionNavItemBlocks($navItemPageId, $placeholderVar)
    {
        $pageBlockItem = \cmsadmin\models\NavItemPageBlockItem::find()->innerJoinWith("block", false, 'LEFT JOIN')->where(['nav_item_page_id' => $navItemPageId, 'placeholder_var' => $placeholderVar])->all();

        $data = [];

        foreach ($pageBlockItem as $item) {
            $block = $item->block;

            $block['json_config'] = json_decode($block['json_config'], true);

            $data[] = array('page_block_item' => $item, 'block' => $block);
        }

        return $data;
    }
    /**

     $array = [
     'nav_item_page' => [...],
     '__placeholders' => [
     ['content' => [...]],
     ['banner' => [
     ['__nav_item_page_block_items' => [
     ['block1' => [...],
     ['block2' => [

     * RECUSRION *

     ['__placholders' => [
     ['content' => [...]],
     ['banner' => [...]]
     ]

     ],
     ]
     ],
     ]
     ];

     http://localhost/luya-website/application/admin/api-cms-navitem/tree?access-token=<ACCESS_TOKEN>&navItemPageId=3

     */
    public function actionTree($navItemPageId)
    {
        $nav_item_page = (new \yii\db\Query())->select("*")->from("cms_nav_item_page t1")->leftJoin("cms_layout", "cms_layout.id=t1.layout_id")->where(['t1.id' => $navItemPageId])->one();

        $return = [
            'nav_item_page' => ['id' => $nav_item_page['id'], 'layout_id' => $nav_item_page['layout_id'], 'layout_name' => $nav_item_page['name']],
            '__placeholders' => [],
        ];

        $nav_item_page['json_config'] = json_decode($nav_item_page['json_config'], true);

        if (isset($nav_item_page['json_config']['placeholders'])) {
            foreach ($nav_item_page['json_config']['placeholders'] as $placeholderKey => $placeholder) {
                $placeholder['nav_item_page_id'] = $navItemPageId;
                $placeholder['prev_id'] = 0;
                $placeholder['__nav_item_page_block_items'] = [];

                $return['__placeholders'][$placeholderKey] = $placeholder;

                $placeholderVar = $placeholder['var'];

                $return['__placeholders'][$placeholderKey]['__nav_item_page_block_items'] = $this->getSub($placeholderVar, $navItemPageId, 0);
            }
        }

        return $return;
    }

    private function getSub($placeholderVar, $navItemPageId, $prevId)
    {
        $nav_item_page_block_item_data = (new \yii\db\Query())->select([
                't1_id' => 't1.id', 't1_nav_item_page_id' => 't1.nav_item_page_id', 't1_json_config_values' => 't1.json_config_values', 't1_placeholder_var' => 't1.placeholder_var', 't1_prev_id' => 't1.prev_id',
                't2_id' => 't2.id', 't2_name' => 't2.name', 't2_json_config' => 't2.json_config',
        ])->from("cms_nav_item_page_block_item t1")->leftJoin("cms_block t2", "t2.id=t1.block_id")->where(['t1.prev_id' => $prevId, 't1.nav_item_page_id' => $navItemPageId, 't1.placeholder_var' => $placeholderVar])->all();

        $data = [];

        foreach ($nav_item_page_block_item_data as $ipbid_key => $ipbid_value) {
            $ipbid_value['t1_json_config_values'] = json_decode($ipbid_value['t1_json_config_values'], true);
            $ipbid_value['t2_json_config'] = json_decode($ipbid_value['t2_json_config'], true);

            $placeholders = [];

            if (isset($ipbid_value['t2_json_config']['placeholders'])) {
                foreach ($ipbid_value['t2_json_config']['placeholders'] as $pk => $pv) {
                    $pv['nav_item_page_id'] = $navItemPageId;
                    $pv['prev_id'] = $ipbid_value['t1_id'];
                    $placeholderVar = $pv['var'];

                    $pv['__nav_item_page_block_items'] = $this->getSub($placeholderVar, $navItemPageId, $ipbid_value['t1_id']);

                    $placeholder = $pv;

                    $placeholders[] = $placeholder;
                }
            }

            $keys = [];

            if (isset($ipbid_value['t2_json_config']['vars'])) {
                $keys = $ipbid_value['t2_json_config']['vars'];
            }

            $nav_item_page_block_item = [
                'id' => $ipbid_value['t1_id'],
                'name' => $ipbid_value['t2_name'],
                'keys' => $keys,
                'values' => $ipbid_value['t1_json_config_values'],
                '__placeholders' => $placeholders,
            ];

            $data[] = $nav_item_page_block_item;
        }

        return $data;
    }
}
