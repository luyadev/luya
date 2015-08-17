<?php

namespace tests\src\web;

use Yii;
use tests\data\Model;

class ModelTest extends \tests\BaseWebTest
{
    public function testNgRest()
    {
        $model = new Model();
        $model->attributes = [
            'i18n_text' => ['de' => 'foo-de', 'en' => 'foo-en'],
            'i18n_textarea' => ['de' => 'foo-de', 'en' => 'foo-en'],
            'date' => time(),
            'datetime' => time(),
            'file_array' => [['fileId' => 1, 'caption' => 'foo bar 1'], ['fileId' => 2, 'caption' => 'foo bar 2'], ],
            'image_array' => [['imageId' => 1, 'caption' => 'foo bar 1'], ['imageId' => 2, 'caption' => 'foo bar 2'], ],
            'select' => 1,
        ];
        $insert = $model->insert(false);
        
        $this->assertEquals(true, $insert);
        
        $id = $model->getPrimaryKey();

        $find = Model::findOne($id);
        
        $this->assertEquals('foo-de', $find->i18n_text);
        $this->assertEquals('foo-de', $find->i18n_textarea);
        $this->assertEquals(true, is_array($find->file_array));
        $this->assertEquals(true, is_array($find->image_array));
        
        Yii::$app->request->setQueryParams([
            'ngrestCallType' => 'list'
        ]);
        
        unset($model);
        unset($find);
        
        $find = Model::findOne($id);
        
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