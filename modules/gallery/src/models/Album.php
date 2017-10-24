<?php

namespace luya\gallery\models;

use luya\gallery\admin\Module;
use luya\helpers\Url;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\aws\ImageSelectCollectionActiveWindow;
use luya\admin\traits\SortableTrait;
use yii\helpers\Inflector;

/**
 * This is the model class for table "gallery_album".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property string $title
 * @property string $description
 * @property integer $cover_image_id
 * @property integer $timestamp_create
 * @property integer $timestamp_update
 * @property integer $is_highlight
 * @property integer $sort_index
 */
class Album extends NgRestModel
{
    use SortableTrait;
    
    /**
     * @inheritdoc
     */
    public $i18n = ['title', 'description'];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_album';
    }
    
    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-gallery-album';
    }
    
    /**
     * @inheritdoc
     */
    public static function sortableField()
    {
        return 'sort_index';
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->on(self::EVENT_BEFORE_DELETE, function($event) {
            $this->unlinkAll('albumImages', true);
        });
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'cover_image_id', 'timestamp_create', 'timestamp_update', 'is_highlight', 'sort_index'], 'integer'],
            [['title'], 'required'],
            [['title', 'description'], 'string'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => Module::t('album_cat_id'),
            'title' => Module::t('album_title'),
            'description' => Module::t('album_description'),
            'cover_image_id' => Module::t('album_cover_image_id'),
            'sort_index' => Module::t('album_sort_index'),
            'is_highlight' => Module::t('album_is_highlight'),
            'timestamp_create' => 'Timestamp Create',
            'timestamp_update' => 'Timestamp Update',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'title' => 'text',
            'description' => 'textarea',
            'cover_image_id' => 'image',
            'cat_id' => ['selectModel', 'modelClass' => Cat::className(), 'valueField' => 'id', 'labelField' => 'title'],
            'sort_index' => 'sortable',
            'is_highlight' => 'toggleStatus',
        ];
    }

   /**
    * @inheritdoc
    */
    public function ngRestActiveWindows()
    {
        return [
            [
                'class' => ImageSelectCollectionActiveWindow::class,
                'refTableName' => 'gallery_album_image',
                'imageIdFieldName' => 'image_id',
                'refFieldName' => 'album_id',
                'sortIndexFieldName' => 'sortindex',
                'alias' => Module::t('album_upload')
            ]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            [['list'], ['title', 'sort_index', 'is_highlight', 'cover_image_id']],  
            [['update', 'create'], ['cat_id', 'title', 'description', 'cover_image_id', 'is_highlight']],
            [['delete'], true],
        ];
    }
    
    /**
     * Get the Album Category.
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Cat::class, ['id' => 'cat_id']);
    }
    
    /**
     * Get Album Images.
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumImages()
    {
        return $this->hasMany(AlbumImage::class, ['album_id' => 'id']);
    }
    
    /**
     * Return the detail link for the current model.
     * 
     * @return string
     */
    public function getDetailLink()
    {
        return Url::toRoute(['/gallery/album/index', 'albumId' => $this->id, 'title' => Inflector::slug($this->title)]);
    }
    
    // deprecated methods  for 1.0.0
    
    public function getCategoryUrl()
    {
        trigger_error('getCategoryUrl() is deprecated use the getCat() / $cat relation ActiveQuery instead.', E_USER_DEPRECATED);
        
        $category = Cat::findOne($this->cat_id);
        
        return Url::toRoute(['/gallery/alben/index', 'catId' => $category->id, 'title' => \yii\helpers\Inflector::slug($category->title)]);
    }
    
    public function getCategoryName()
    {
        trigger_error('getCategoryName() is deprecated use the getCat() / $cat relation ActiveQuery instead.', E_USER_DEPRECATED);
        $category = Cat::findOne($this->cat_id);
        
        return $category->title;
    }
    
    public function getDetailUrl($contextNavItemId = null)
    {
        trigger_error('getDetailUrl() is deprecated use the getCat() / $cat relation ActiveQuery instead.', E_USER_DEPRECATED);
        if ($contextNavItemId) {
            return \luya\cms\helpers\Url::toMenuItem($contextNavItemId, 'gallery/album/index', ['albumId' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
        }
        
        return Url::toRoute(['/gallery/album/index', 'albumId' => $this->id, 'title' => \yii\helpers\Inflector::slug($this->title)]);
    }
    
    public function images()
    {
        trigger_error('images() is depreacted use the getAlbumImages() / $albumImages relation ActiveQuery instead.', E_USER_DEPRECATED);
        return (new \yii\db\Query())->from('gallery_album_image')->where(['album_id' => $this->id])->all();
    }
}
