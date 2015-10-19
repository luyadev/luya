<?php

namespace admin\models;

/**
 * This is the model class for table "admin_group".
 *
 * @property int $group_id
 * @property string $name
 * @property string $text
 */
class StorageEffect extends \admin\ngrest\base\Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_storage_effect';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'identifier', 'imagine_name', 'imagine_json_params'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            'default' => ['name', 'identifier', 'imagine_name', 'imagine_json_params'],
            'restcreate' => ['name', 'identifier', 'imagine_name', 'imagine_json_params'],
            'restupdate' => ['name', 'identifier', 'imagine_name', 'imagine_json_params'],
        ];
    }

    // ngrest

    public function ngRestApiEndpoint()
    {
        return 'api-admin-effect';
    }

    public function ngRestConfig($config)
    {
        $config->list->field('name', 'Name')->text();
        $config->list->field('identifier', 'Identifier')->text();
        $config->list->field('imagine_name', 'Imagine Effekt')->text();
        $config->list->field('imagine_json_params', 'Imagine Argumente')->textarea();

        return $config;
    }
}
