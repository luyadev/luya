<?php

namespace tests\web\admin\ngrest\base;

use Yii;
use tests\data\models\DummyTableModel;

class ModelTest extends \tests\web\Base
{
    public function testNgRest()
    {
        $time = time();

        $model = new DummyTableModel();
        $model->attributes = [
            'i18n_text' => ['de' => 'foo-de', 'en' => 'foo-en'],
            'i18n_textarea' => ['de' => 'foo-de', 'en' => 'foo-en'],
            'date' => $time,
            'datetime' => $time,
            'file_array' => [['fileId' => 1, 'caption' => 'foo bar 1'], ['fileId' => 2, 'caption' => 'foo bar 2']],
            'image_array' => [['imageId' => 1, 'caption' => 'foo bar 1'], ['imageId' => 2, 'caption' => 'foo bar 2']],
            'select' => 1,
            'cms_page' => 1,
        ];
        $insert = $model->insert(false);

        $this->assertEquals(true, $insert);

        $id = $model->getPrimaryKey();

        $find = DummyTableModel::findOne($id);

        $this->assertEquals('foo-en', $find->i18n_text);
        $this->assertEquals('foo-en', $find->i18n_textarea);
        $this->assertEquals(true, is_array($find->file_array));
        $this->assertEquals(true, is_array($find->image_array));
        $this->assertEquals($time, $find->date);
        $this->assertEquals($time, $find->datetime);
        $this->assertInstanceOf('cms\menu\Item', $find->cms_page);

        // list

        Yii::$app->request->setQueryParams([
            'ngrestCallType' => 'list',
        ]);

        unset($model);
        unset($find);

        $find = DummyTableModel::findOne($id);

        $this->assertEquals(false, is_array($find->i18n_text));
        $this->assertEquals(false, is_array($find->i18n_textarea));
        $this->assertEquals('foo-en', $find->i18n_text);
        $this->assertEquals('foo-en', $find->i18n_textarea);
        $this->arrayHasKey('de', $find->i18n_text);
        $this->arrayHasKey('en', $find->i18n_text);
        $this->arrayHasKey('de', $find->i18n_textarea);
        $this->arrayHasKey('en', $find->i18n_textarea);
        
        // update

        Yii::$app->request->setQueryParams([
            'ngrestCallType' => 'update',
        ]);
        
        unset($model);
        unset($find);
        
        $find = DummyTableModel::findOne($id);
        
        $this->assertEquals(true, is_array($find->i18n_text));
        $this->assertEquals(true, is_array($find->i18n_textarea));
        $this->arrayHasKey('de', $find->i18n_text);
        $this->arrayHasKey('en', $find->i18n_text);
        $this->arrayHasKey('de', $find->i18n_textarea);
        $this->arrayHasKey('en', $find->i18n_textarea);
        $this->assertEquals('foo-de', $find->i18n_text['de']);
        $this->assertEquals('foo-en', $find->i18n_text['en']);
        $this->assertEquals('foo-de', $find->i18n_textarea['de']);
        $this->assertEquals('foo-en', $find->i18n_textarea['en']);
    }
}
