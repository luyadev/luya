<?php

namespace luya\admin\models;

use luya\admin\file\Item;
use luya\admin\ngrest\base\NgRestModel;

/**
 * This is the model class for table "admin_group".
 *
 * @property int $group_id
 * @property string $name
 * @property string $text
 */
class StorageFilter extends NgRestModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_storage_filter';
    }

    /**
     * {@inheritdoc}
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
            'default' => ['name', 'identifier'],
            'restcreate' => ['name', 'identifier'],
            'restupdate' => ['name', 'identifier'],
        ];
    }
    
    public function removeImageSources()
    {
        foreach (StorageImage::find()->where(['filter_id' => $this->id])->all() as $img) {
            $img->deleteSource();
        }
    }
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            foreach (StorageImage::find()->where(['filter_id' => $this->id])->all() as $img) {
                $img->delete();
            }
            return true;
        }
        
        return false;
    }
    

    public function applyFilterChain(Item $file, $fileSavePath)
    {
        $loadFrom = $file->getServerSource();
        
        foreach (StorageFilterChain::find()->where(['filter_id' => $this->id])->joinWith('effect')->all() as $chain) {
            $response = $chain->applyFilter($loadFrom, $fileSavePath);
            $loadFrom = $fileSavePath;
        }
        
        return true;
    }

    // ngrest

    public static function ngRestApiEndpoint()
    {
        return 'api-admin-filter';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('name', 'Name')->text();
        $config->list->field('identifier', 'Identifier')->text();

        $config->create->copyFrom('list');
        $config->update->copyFrom('list');

        return $config;
    }
}
