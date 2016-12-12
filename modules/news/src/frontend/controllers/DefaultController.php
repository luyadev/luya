<?php

namespace luya\news\frontend\controllers;

use luya\news\models\Article;
use luya\news\models\Cat;
use yii\data\ActiveDataProvider;

/**
 * News Module Default Controller contains actions to display and render views with predefined data.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class DefaultController extends \luya\web\Controller
{
    /**
     * Get Article overview.
     * 
     * The index action will return an active data provider object inside the $provider variable:
     * 
     * ```php
     * foreach ($provider->models as $item) {
     *     var_dump($item);
     * }
     * ```
     * 
     * @return string
     */
    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query' => Article::find()->andWhere(['is_deleted' => 0]),
        ]);
        
        return $this->render('index', [
            'model' => Article::className(),
            'provider' => $provider,
        ]);
    }

    /**
     * Get the category Model for a specific ID.
     *
     * The most common way is to use the active data provider object inside the $provider variable:
     * 
     * ```php
     * foreach ($provider->getModels() as $cat) {
     *     var_dump($cat);
     * }
     * ```
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
        
        $provider = new ActiveDataProvider([
            'query' => $model->getArticles(),
        ]);
        
        return $this->render('category', [
            'model' => $model,
            'provider' => $provider,
        ]);
    }
    
    /**
     * Detail Action of an article by Id.
     *
     * @param integer $id
     * @param string $title
     * @return \yii\web\Response|string
     */
    public function actionDetail($id, $title)
    {
        $model = Article::findOne(['id' => $id, 'is_deleted' => 0]);
        
        if (!$model) {
            return $this->goHome();
        }
        
        return $this->render('detail', [
            'model' => $model,
        ]);
    }
}
