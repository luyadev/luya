<?php
namespace admin\models;

/**
 * This is the model class for table "admin_group".
 *
 * @property integer $group_id
 * @property string $name
 * @property string $text
 */
class StorageFilter extends \admin\ngrest\base\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_storage_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name'],
            'restupdate' => ['name'],
        ];
    }
    
    public function applyFilter($imagine)
    {
        $chain = \admin\models\StorageFilterChain::find()->where(['filter_id' => $this->id ])->joinWith('effect')->all();
        
        foreach ($chain as $item) {
            switch ($item->effect->imagine_name) {
                case "resize":
                    $imagine->resize(new \Imagine\Image\Box($item->effect_json_values->width, $item->effect_json_values->height));
                    break;
            }
        }
        
        return $imagine;
    }
    
    // ngrest

    public $ngRestEndpoint = 'api-admin-filter';

    public function ngRestConfig($config)
    {
        $config->strap->register(new \admin\straps\FilterEffectChain(), "Chain");
        
        $config->list->field("name", "Name")->text()->required();
        $config->list->field("id", "ID")->text();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        return $config;
    }
}
