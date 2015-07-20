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
            [['name', 'identifier'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['name', 'identifier'],
            'restupdate' => ['name', 'identifier'],
        ];
    }

    public function applyFilter($image, $imagine)
    {
        $newimage = null;

        $chain = \admin\models\StorageFilterChain::find()->where(['filter_id' => $this->id])->joinWith('effect')->all();

        foreach ($chain as $item) {
            switch ($item->effect->imagine_name) {
                case 'resize':
                    if (is_null($newimage)) {
                        $newimage = $image->resize(new \Imagine\Image\Box($item->effect_json_values->width, $item->effect_json_values->height));
                    } else {
                        $newimage = $newimage->resize(new \Imagine\Image\Box($item->effect_json_values->width, $item->effect_json_values->height));
                    }
                    break;
                case 'thumbnail':
                    if (is_null($newimage)) {
                        // THUMBNAIL_OUTBOUND & THUMBNAIL_INSET
                        if (!isset($item->effect_json_values->type)) {
                            $item->effect_json_values->type = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                        }
                        $newimage = $image->thumbnail(new \Imagine\Image\Box($item->effect_json_values->width, $item->effect_json_values->height), $item->effect_json_values->type);
                    } else {
                        $newimage = $newimage->thumbnail(new \Imagine\Image\Box($item->effect_json_values->width, $item->effect_json_values->height), $item->effect_json_values->type);
                    }
                    break;
                case 'crop':
                    if (is_null($newimage)) {
                        $newimage = $image->crop(new \Imagine\Image\Point(0, 0), new \Imagine\Image\Box($item->effect_json_values->width, $item->effect_json_values->height));
                    } else {
                        $newimage = $newimage->crop(new \Imagine\Image\Point(0, 0), new \Imagine\Image\Box($item->effect_json_values->width, $item->effect_json_values->height));
                    }
                    break;
            }
        }

        return $newimage;
    }

    // ngrest

    public function ngRestApiEndpoint()
    {
        return 'api-admin-filter';
    }

    public function ngRestConfig($config)
    {
        //$config->aw->register(new \admin\aws\FilterEffectChain(), 'Chain');

        $config->list->field('name', 'Name')->text();
        $config->list->field('identifier', 'Identifier')->text();
        $config->list->field('id', 'ID')->text();

        $config->create->copyFrom('list', ['id']);
        $config->update->copyFrom('list', ['id']);

        return $config;
    }
}
