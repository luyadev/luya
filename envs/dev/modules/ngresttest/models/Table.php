<?php

namespace ngresttest\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Table.
 *
 * File has been created with `crud/create` command on LUYA version 1.0.0-RC2-dev.
 *
 * @property integer $id
 * @property text $image
 * @property text $imageArray
 * @property text $file
 * @property text $fileArray
 * @property text $text
 * @property text $textarea
 * @property text $selectArray
 * @property text $checkboxList
 * @property text $checkboxRelation
 * @property text $color
 * @property text $date
 * @property text $datetime
 * @property text $decimal
 * @property text $number
 * @property text $password
 * @property text $selectClass
 * @property text $toggleStatus
 * @property text $sortRelationArray
 * @property text $sortRelationModel
 * @property text $i18n_image
 * @property text $i18n_imageArray
 * @property text $i18n_file
 * @property text $i18n_fileArray
 * @property text $i18n_text
 * @property text $i18n_textarea
 * @property text $i18n_selectArray
 * @property text $i18n_checkboxList
 * @property text $i18n_checkboxRelation
 * @property text $i18n_color
 * @property text $i18n_date
 * @property text $i18n_datetime
 * @property text $i18n_decimal
 * @property text $i18n_number
 * @property text $i18n_password
 * @property text $i18n_selectClass
 * @property text $i18n_toggleStatus
 * @property text $i18n_sortRelationArray
 * @property text $i18n_sortRelationModel
 */
class Table extends NgRestModel
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
            'id' => Yii::t('app', 'ID'),
            'image' => Yii::t('app', 'Image'),
            'imageArray' => Yii::t('app', 'Image Array'),
            'file' => Yii::t('app', 'File'),
            'fileArray' => Yii::t('app', 'File Array'),
            'text' => Yii::t('app', 'Text'),
            'textarea' => Yii::t('app', 'Textarea'),
            'selectArray' => Yii::t('app', 'Select Array'),
            'checkboxList' => Yii::t('app', 'Checkbox List'),
            'checkboxRelation' => Yii::t('app', 'Checkbox Relation'),
            'color' => Yii::t('app', 'Color'),
            'date' => Yii::t('app', 'Date'),
            'datetime' => Yii::t('app', 'Datetime'),
            'decimal' => Yii::t('app', 'Decimal'),
            'number' => Yii::t('app', 'Number'),
            'password' => Yii::t('app', 'Password'),
            'selectClass' => Yii::t('app', 'Select Class'),
            'toggleStatus' => Yii::t('app', 'Toggle Status'),
            'sortRelationArray' => Yii::t('app', 'Sort Relation Array'),
            'sortRelationModel' => Yii::t('app', 'Sort Relation Model'),
            'i18n_image' => Yii::t('app', 'I18n Image'),
            'i18n_imageArray' => Yii::t('app', 'I18n Image Array'),
            'i18n_file' => Yii::t('app', 'I18n File'),
            'i18n_fileArray' => Yii::t('app', 'I18n File Array'),
            'i18n_text' => Yii::t('app', 'I18n Text'),
            'i18n_textarea' => Yii::t('app', 'I18n Textarea'),
            'i18n_selectArray' => Yii::t('app', 'I18n Select Array'),
            'i18n_checkboxList' => Yii::t('app', 'I18n Checkbox List'),
            'i18n_checkboxRelation' => Yii::t('app', 'I18n Checkbox Relation'),
            'i18n_color' => Yii::t('app', 'I18n Color'),
            'i18n_date' => Yii::t('app', 'I18n Date'),
            'i18n_datetime' => Yii::t('app', 'I18n Datetime'),
            'i18n_decimal' => Yii::t('app', 'I18n Decimal'),
            'i18n_number' => Yii::t('app', 'I18n Number'),
            'i18n_password' => Yii::t('app', 'I18n Password'),
            'i18n_selectClass' => Yii::t('app', 'I18n Select Class'),
            'i18n_toggleStatus' => Yii::t('app', 'I18n Toggle Status'),
            'i18n_sortRelationArray' => Yii::t('app', 'I18n Sort Relation Array'),
            'i18n_sortRelationModel' => Yii::t('app', 'I18n Sort Relation Model'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image', 'imageArray', 'file', 'fileArray', 'text', 'textarea', 'selectArray', 'checkboxList', 'checkboxRelation', 'color', 'date', 'datetime', 'decimal', 'number', 'password', 'selectClass', 'toggleStatus', 'sortRelationArray', 'sortRelationModel', 'i18n_image', 'i18n_imageArray', 'i18n_file', 'i18n_fileArray', 'i18n_text', 'i18n_textarea', 'i18n_selectArray', 'i18n_checkboxList', 'i18n_checkboxRelation', 'i18n_color', 'i18n_date', 'i18n_datetime', 'i18n_decimal', 'i18n_number', 'i18n_password', 'i18n_selectClass', 'i18n_toggleStatus', 'i18n_sortRelationArray', 'i18n_sortRelationModel'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['restcreate'] = ['image', 'imageArray', 'file', 'fileArray', 'text', 'textarea', 'selectArray', 'checkboxList', 'checkboxRelation', 'color', 'date', 'datetime', 'decimal', 'number', 'password', 'selectClass', 'toggleStatus', 'sortRelationArray', 'sortRelationModel', 'i18n_image', 'i18n_imageArray', 'i18n_file', 'i18n_fileArray', 'i18n_text', 'i18n_textarea', 'i18n_selectArray', 'i18n_checkboxList', 'i18n_checkboxRelation', 'i18n_color', 'i18n_date', 'i18n_datetime', 'i18n_decimal', 'i18n_number', 'i18n_password', 'i18n_selectClass', 'i18n_toggleStatus', 'i18n_sortRelationArray', 'i18n_sortRelationModel'];
        $scenarios['restupdate'] = ['image', 'imageArray', 'file', 'fileArray', 'text', 'textarea', 'selectArray', 'checkboxList', 'checkboxRelation', 'color', 'date', 'datetime', 'decimal', 'number', 'password', 'selectClass', 'toggleStatus', 'sortRelationArray', 'sortRelationModel', 'i18n_image', 'i18n_imageArray', 'i18n_file', 'i18n_fileArray', 'i18n_text', 'i18n_textarea', 'i18n_selectArray', 'i18n_checkboxList', 'i18n_checkboxRelation', 'i18n_color', 'i18n_date', 'i18n_datetime', 'i18n_decimal', 'i18n_number', 'i18n_password', 'i18n_selectClass', 'i18n_toggleStatus', 'i18n_sortRelationArray', 'i18n_sortRelationModel'];
        return $scenarios;
    }
    
    /**
     * @return array An array containing all field which can be lookedup during the admin search process.
     */
    public function genericSearchFields()
    {
        return ['image', 'imageArray', 'file', 'fileArray', 'text', 'textarea', 'selectArray', 'checkboxList', 'checkboxRelation', 'color', 'date', 'datetime', 'decimal', 'number', 'password', 'selectClass', 'toggleStatus', 'sortRelationArray', 'sortRelationModel', 'i18n_image', 'i18n_imageArray', 'i18n_file', 'i18n_fileArray', 'i18n_text', 'i18n_textarea', 'i18n_selectArray', 'i18n_checkboxList', 'i18n_checkboxRelation', 'i18n_color', 'i18n_date', 'i18n_datetime', 'i18n_decimal', 'i18n_number', 'i18n_password', 'i18n_selectClass', 'i18n_toggleStatus', 'i18n_sortRelationArray', 'i18n_sortRelationModel'];
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
    public function ngRestAttributeTypes()
    {
        return [
            'image' => 'link',
            'imageArray' => 'textarea',
            'file' => 'textarea',
            'fileArray' => 'textarea',
            'text' => 'textarea',
            'textarea' => 'textarea',
            'selectArray' => 'textarea',
            'checkboxList' => 'textarea',
            'checkboxRelation' => 'textarea',
            'color' => 'textarea',
            'date' => 'textarea',
            'datetime' => 'textarea',
            'decimal' => 'textarea',
            'number' => 'textarea',
            'password' => 'textarea',
            'selectClass' => 'textarea',
            'toggleStatus' => 'textarea',
            'sortRelationArray' => 'textarea',
            'sortRelationModel' => 'textarea',
            'i18n_image' => 'textarea',
            'i18n_imageArray' => 'textarea',
            'i18n_file' => 'textarea',
            'i18n_fileArray' => 'textarea',
            'i18n_text' => 'textarea',
            'i18n_textarea' => 'textarea',
            'i18n_selectArray' => 'textarea',
            'i18n_checkboxList' => 'textarea',
            'i18n_checkboxRelation' => 'textarea',
            'i18n_color' => 'textarea',
            'i18n_date' => 'textarea',
            'i18n_datetime' => 'textarea',
            'i18n_decimal' => 'textarea',
            'i18n_number' => 'textarea',
            'i18n_password' => 'textarea',
            'i18n_selectClass' => 'textarea',
            'i18n_toggleStatus' => 'textarea',
            'i18n_sortRelationArray' => ['sortRelationArray', 'data' => [1 => 'Foo', 2 => 'Bar']],
            'i18n_sortRelationModel' => 'textarea',
        ];
    }
    
    /**
     * Define the NgRestConfig for this model with the ConfigBuilder object.
     *
     * @param \luya\admin\ngrest\ConfigBuilder $config The current active config builder object.
     * @return \luya\admin\ngrest\ConfigBuilder
     */
    public function ngRestConfig($config)
    {
        // define fields for types based from ngrestAttributeTypes
        $this->ngRestConfigDefine($config, 'list', ['image']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['image', 'i18n_sortRelationArray']);
        
        // enable or disable ability to delete;
        $config->delete = false;
        
        return $config;
    }
}
