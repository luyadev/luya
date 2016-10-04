<?php

namespace ngresttest\models;

use Yii;
use luya\admin\models\User;
use luya\admin\aws\FlowActiveWindow;
use luya\admin\aws\FlowActiveWindowInterface;
use luya\admin\image\Item;
use yii\db\Query;
use luya\helpers\ArrayHelper;
use luya\admin\ngrest\base\NgRestModel;

/**
 * NgRest Model created at 21.03.2016 14:05 on LUYA Version 1.0.0-beta6-dev.
 */
class Table extends NgRestModel implements FlowActiveWindowInterface
{
        /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ngresttest_table';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image' => Yii::t('app', 'Image'),
            'imageArray' => Yii::t('app', 'ImageArray'),
            'file' => Yii::t('app', 'File'),
            'fileArray' => Yii::t('app', 'FileArray'),
            'text' => Yii::t('app', 'Text'),
            'textarea' => Yii::t('app', 'Textarea'),
            'selectArray' => Yii::t('app', 'SelectArray'),
            'checkboxList' => Yii::t('app', 'CheckboxList'),
            'checkboxRelation' => Yii::t('app', 'CheckboxRelation'),
            'color' => Yii::t('app', 'Color'),
            'date' => Yii::t('app', 'Date'),
            'datetime' => Yii::t('app', 'Datetime'),
            'decimal' => Yii::t('app', 'Decimal'),
            'number' => Yii::t('app', 'Number'),
            'password' => Yii::t('app', 'Password'),
            'selectClass' => Yii::t('app', 'SelectClass'),
            'toggleStatus' => Yii::t('app', 'ToggleStatus'),
            'i18n_image' => Yii::t('app', 'I18n image'),
            'i18n_imageArray' => Yii::t('app', 'I18n imageArray'),
            'i18n_file' => Yii::t('app', 'I18n file'),
            'i18n_fileArray' => Yii::t('app', 'I18n fileArray'),
            'i18n_text' => Yii::t('app', 'I18n text'),
            'i18n_textarea' => Yii::t('app', 'I18n textarea'),
            'i18n_selectArray' => Yii::t('app', 'I18n selectArray'),
            'i18n_checkboxList' => Yii::t('app', 'I18n checkboxList'),
            'i18n_checkboxRelation' => Yii::t('app', 'I18n checkboxRelation'),
            'i18n_color' => Yii::t('app', 'I18n color'),
            'i18n_date' => Yii::t('app', 'I18n date'),
            'i18n_datetime' => Yii::t('app', 'I18n datetime'),
            'i18n_decimal' => Yii::t('app', 'I18n decimal'),
            'i18n_number' => Yii::t('app', 'I18n number'),
            'i18n_password' => Yii::t('app', 'I18n password'),
            'i18n_selectClass' => Yii::t('app', 'I18n selectClass'),
            'i18n_toggleStatus' => Yii::t('app', 'I18n toggleStatus'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    // ngrest base model methods
    /**
     * @var An array containing all fields which should be transformed to multilingual fields and stored as json in the database.
     */
    public $i18n = ['i18n_sortRelationArray', 'i18n_sortRelationModel', 'i18n_image', 'i18n_imageArray', 'i18n_file', 'i18n_fileArray', 'i18n_text', 'i18n_textarea', 'i18n_selectArray', 'i18n_checkboxList', 'i18n_date', 'i18n_datetime', 'i18n_decimal', 'i18n_number', 'i18n_password',  'i18n_toggleStatus'];

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['restcreate'] = ['sortRelationArray', 'sortRelationModel', 'i18n_sortRelationArray', 'i18n_sortRelationModel', 'image', 'imageArray', 'file', 'fileArray', 'text', 'textarea', 'selectArray', 'checkboxList', 'date', 'datetime', 'decimal', 'number', 'password',  'toggleStatus', 'i18n_image', 'i18n_imageArray', 'i18n_file', 'i18n_fileArray', 'i18n_text', 'i18n_textarea', 'i18n_selectArray', 'i18n_checkboxList', 'i18n_date', 'i18n_datetime', 'i18n_decimal', 'i18n_number', 'i18n_password',  'i18n_toggleStatus'];
        $scenarios['restupdate'] = ['sortRelationArray', 'sortRelationModel', 'i18n_sortRelationArray', 'i18n_sortRelationModel', 'image', 'imageArray', 'file', 'fileArray', 'text', 'textarea', 'selectArray', 'checkboxList', 'date', 'datetime', 'decimal', 'number', 'password',  'toggleStatus', 'i18n_image', 'i18n_imageArray', 'i18n_file', 'i18n_fileArray', 'i18n_text', 'i18n_textarea', 'i18n_selectArray', 'i18n_checkboxList', 'i18n_date', 'i18n_datetime', 'i18n_decimal', 'i18n_number', 'i18n_password',  'i18n_toggleStatus'];
        return $scenarios;
    }

    /**
     * @return array An array containing all field which can be lookedup during the admin search process.
     */
    public function genericSearchFields()
    {
        return ['image', 'imageArray', 'file', 'fileArray', 'text', 'textarea', 'selectArray', 'checkboxList', 'date', 'datetime', 'decimal', 'number', 'password',  'toggleStatus', 'i18n_image', 'i18n_imageArray', 'i18n_file', 'i18n_fileArray', 'i18n_text', 'i18n_textarea', 'i18n_selectArray', 'i18n_checkboxList', 'i18n_date', 'i18n_datetime', 'i18n_decimal', 'i18n_number', 'i18n_password',  'i18n_toggleStatus'];
    }

    /**
     * @return string Defines the api endpoint for the angular calls
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-ngresttest-table';
    }

    /**
     * @return array An array define the field types of each field
     */
    public function ngrestAttributeTypes()
    {
        /*return [
            'sortRelationArray' => ['sortRelationArray', 'data' => ['hi', 'ho', 'hi2', 'ho2', 'hi3', 'ho3', 'hi4', 'ho4', 'hi5', 'ho5', 'hi5', 'ho5', 'hi6', 'ho6', 'hi7', 'ho7']],
            'sortRelationModel' => ['SortRelationModel', 'modelClass' => User::className(), 'valueField' => 'id', 'labelField' => 'email'],
            'i18n_sortRelationArray' => ['SortRelationArray', 'data' => ['hi', 'ho']],
            'i18n_sortRelationModel' => ['SortRelationModel', 'modelClass' => User::className(), 'valueField' => 'id', 'labelField' => 'email']
        ];*/
        return [
            'image' => 'image',
            'imageArray' => 'imageArray',
            'file' => 'file',
            'fileArray' => 'fileArray',
            'text' => 'text',
            'textarea' => 'textarea',
            'selectArray' => ['selectArray', 'data' => [1 => 'Male', 2 => 'Female', 'homo' => 'Homobulusl', '4' => 'A string casted number!']],
            'checkboxList' => ['checkboxList', 'data' => [1 => 'Male', 2 => 'Female', 'homo' => 'Homobulusl', '4' => 'A string casted number!']],
            //'checkboxRelation' => 'textarea',
            //'color' =>
            'date' => 'date',
            'datetime' => 'datetime',
            'decimal' => 'decimal',
            'number' => 'number',
            'password' => 'password',
            //'selectClass' => 'textarea',
            'toggleStatus' => 'toggleStatus',

            'i18n_image' => 'image',
            'i18n_imageArray' => 'imageArray',
            'i18n_file' => 'file',
            'i18n_fileArray' => 'fileArray',
            'i18n_text' => 'text',
            'i18n_textarea' => 'textarea',
            'i18n_selectArray' => ['selectArray', 'data' => [1 => 'Male', 2 => 'Female', 'homo' => 'Homobulusl', '4' => 'A string casted number!']],
            'i18n_checkboxList' => ['checkboxList', 'data' => [1 => 'Male', 2 => 'Female', 'homo' => 'Homobulusl', '4' => 'A string casted number!']], //['checkboxList', ['foo', 'bar']],
            //'checkboxRelation' => 'textarea',
            //'i18n_color' =>
            'i18n_date' => 'date',
            'i18n_datetime' => 'datetime',
            'i18n_decimal' => 'decimal',
            'i18n_number' => 'number',
            'i18n_password' => 'password',
            //'selectClass' => 'textarea',
            'i18n_toggleStatus' => 'toggleStatus',
        ];
    }

    /**
     * @return \admin\ngrest\Config the configured ngrest object
     */
    public function ngRestConfig($config)
    {
        $config->aw->load(['class' => FlowActiveWindow::className(), 'modelClass' => self::className()]);
        // define fields for types based from ngrestAttributeTypes

        $this->ngRestConfigDefine($config, 'list', ['image', 'imageArray', 'file', 'fileArray', 'text', 'textarea', 'selectArray', 'checkboxList', 'date', 'datetime', 'decimal', 'number', 'password', 'toggleStatus', 'i18n_image', 'i18n_imageArray', 'i18n_file', 'i18n_fileArray', 'i18n_text', 'i18n_textarea', 'i18n_selectArray', 'i18n_checkboxList', 'i18n_date', 'i18n_datetime', 'i18n_decimal', 'i18n_number', 'i18n_password',  'i18n_toggleStatus']);
        $this->ngRestConfigDefine($config, 'create', ['image', 'imageArray', 'file', 'fileArray', 'text', 'textarea', 'selectArray', 'checkboxList', 'date', 'datetime', 'decimal', 'number', 'password', 'toggleStatus', 'i18n_image', 'i18n_imageArray', 'i18n_file', 'i18n_fileArray', 'i18n_text', 'i18n_textarea', 'i18n_selectArray', 'i18n_checkboxList', 'i18n_date', 'i18n_datetime', 'i18n_decimal', 'i18n_number', 'i18n_password',  'i18n_toggleStatus']);
        $this->ngRestConfigDefine($config, 'update', ['image', 'imageArray', 'file', 'fileArray', 'text', 'textarea', 'selectArray', 'checkboxList', 'date', 'datetime', 'decimal', 'number', 'password', 'toggleStatus', 'i18n_image', 'i18n_imageArray', 'i18n_file', 'i18n_fileArray', 'i18n_text', 'i18n_textarea', 'i18n_selectArray', 'i18n_checkboxList', 'i18n_date', 'i18n_datetime', 'i18n_decimal', 'i18n_number', 'i18n_password',  'i18n_toggleStatus']);

        // $this->ngRestConfigDefine($config, ['list', 'create', 'update'], ['sortRelationArray', 'i18n_sortRelationArray', 'sortRelationModel', 'i18n_sortRelationModel']);

        // enable or disable ability to delete;
        $config->delete = true;

        return $config;
    }

    public function flowSaveImage(Item $image)
    {
        Yii::$app->db->createCommand()->insert('ngresttest_table_images', [
            'model_id' => $this->id,
            'image_id' => $image->id,
            'sort_index' => 0,
        ])->execute();
    }

    public function flowDeleteImage(Item $image)
    {
    	Yii::$app->db->createCommand()->delete('ngresttest_table_images', ['image_id' => $image->id])->execute();
    }

    public function flowListImages()
    {
        return ArrayHelper::getColumn((new Query())->select(['image_id'])->from('ngresttest_table_images')->where(['model_id' => $this->id])->indexBy('image_id')->all(), 'image_id');
    }
}
