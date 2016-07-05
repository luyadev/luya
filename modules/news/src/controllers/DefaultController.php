<?php

namespace news\controllers;

use newsadmin\models\Article;
use newsadmin\models\Cat;

/**
 * News Module Defaul Controller contains actions to display and render views with predefined data.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class DefaultController extends \luya\web\Controller
{
    /**
     * Index Action
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => Article::className(),
        ]);
    }

    /**
     * Get the category Model for a specific ID.
     * 
     * Inside the Cat Object you can then retrieve its articles:
     * 
     * ```php
     * foreach ($model->articles as $item) {
     * 
     * }
     * ```
     * 
     * or customize the where query:
     * 
     * ```php
     * foreach ($model->getArticles()->where(['timestamp', time())->all() as $item) {
     * 
     * }
     * ```
     * 
     * @param integer $categoryId
     * @return \yii\web\Response|string
     */
    public function actionCategory($categoryId)
    {
        $model = Cat::findOne($categoryId);
        
        if (!$model) {
            return $this->goHome();
        }
        
        return $this->render('category', [
            'model' => $model,
        ]);
    }
    
    /**
     * Detail Action of Article
     * 
     * @param integer $id
     * @param string $title
     * @return \yii\web\Response|string
     */
    public function actionDetail($id, $title)
    {
        $model = Article::findOne($id);
        
        if (!$model) {
            return $this->goHome();
        }
        
        return $this->render('detail', [
            'model' => $model,
        ]);
    }
}
