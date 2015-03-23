<?php
namespace newsadmin\controllers;

class TagController extends \admin\ngrest\base\Controller
{
    public $modelClass = '\\newsadmin\\models\\Tag';

    /*
    public function actionIndex() {
        $data = \newsadmin\models\Article::find()->with('tags')->where(['id' => 1])->one();
        foreach ($data->tags as $k => $v) {
            var_dump($k, $v);
        }
        return 'hi';
    }
    */
}
