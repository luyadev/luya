<?php

namespace luya\admin\apis;

use Yii;
use luya\traits\CacheableTrait;
use luya\admin\models\Property;
use luya\admin\models\Lang;
use luya\admin\base\RestController;
use luya\admin\models\UserLogin;

/**
 * Common Admin API Tasks.
 *
 * Delivers default values for the specifing table. It means it does not return a key numeric array,
 * it does only return 1 assoc array wich reperents the default row.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class CommonController extends RestController
{
    use CacheableTrait;
    
    /**
     * Set the lastest ngrest filter selection in the User Settings.
     *
     * @return boolean
     */
    public function actionNgrestFilter()
    {
        $apiEndpoint = Yii::$app->request->getBodyParam('apiEndpoint');
        $filterName = Yii::$app->request->getBodyParam('filterName');
        
        return Yii::$app->adminuser->identity->setting->set('ngrestfilter.'.$apiEndpoint, $filterName);
    }
    
    /**
     * Set the lastest ngrest curd list order direction in the User Settings.
     *
     * @return boolean
     */
    public function actionNgrestOrder()
    {
        $apiEndpoint = Yii::$app->request->getBodyParam('apiEndpoint');
        $sort = Yii::$app->request->getBodyParam('sort');
        $field = Yii::$app->request->getBodyParam('field');
        
        if ($sort == '-') {
            $sort = SORT_DESC;
        } else {
            $sort = SORT_ASC;
        }
        
        return Yii::$app->adminuser->identity->setting->set('ngrestorder.'.$apiEndpoint, ['sort' => $sort, 'field' => $field]);
    }
    
    /**
     * Get all available languages from the database as array.
     *
     * @return array The available languages.
     */
    public function actionDataLanguages()
    {
        return Lang::find()->asArray()->all();
    }
    
    /**
     * Get all available administration regisetered properties.
     *
     * @return array Get all properties.
     */
    public function actionDataProperties()
    {
        $data = [];
        foreach (Property::find()->all() as $item) {
            $object = Property::getObject($item->class_name);
            $data[] = [
                'id' => $item->id,
                'var_name' => $object->varName(),
                'option_json' => $object->options(),
                'label' => $object->label(),
                'type' => $object->type(),
                'default_value' => $object->defaultValue(),
                'i18n' => $object->i18n,
            ];
        }
        
        return $data;
    }
    
    /**
     * Triggerable action to flush the application cache and force user reload.
     *
     * @return boolean
     */
    public function actionCache()
    {
        if (Yii::$app->has('cache')) {
            Yii::$app->cache->flush();
        }
    
        $user = Yii::$app->adminuser->identity;
        $user->force_reload = false;
        $user->save(false);
    
        return true;
    }
    
    /**
     * Get a list with all frontend modules, which is used in several dropdowns in the admin ui.
     *
     * @return array An array with all frontend modules.
     */
    public function actionDataModules()
    {
        $data = [];
        foreach (Yii::$app->getFrontendModules() as $k => $f) {
            $data[] = ['value' => $k, 'label' => $k];
        }
        return $data;
    }

    /**
     * Save the last selected filemanager folder in the user settings.
     *
     * @return boolean
     */
    public function actionSaveFilemanagerFolderState()
    {
        $folderId = Yii::$app->request->getBodyParam('folderId');
        
        if ($folderId) {
            return Yii::$app->adminuser->identity->setting->set('filemanagerFolderId', $folderId);
        } else {
            return Yii::$app->adminuser->identity->setting->remove('filemanagerFolderId');
        }
    }
    
    /**
     * Return the latest selected filemanager from the user settings.
     *
     * @return integer The folder id.
     */
    public function actionGetFilemanagerFolderState()
    {
        return Yii::$app->adminuser->identity->setting->get('filemanagerFolderId', 0);
    }

    /**
     * Store the open and closed folders from the filemanager tree in the user settings.
     *
     * @return booelan
     */
    public function actionFilemanagerFoldertreeHistory()
    {
        $this->deleteHasCache('storageApiDataFolders');

        $data = Yii::$app->request->getBodyParam('data');
        Yii::$app->adminuser->identity->setting->set('foldertree.'.$data['id'], (int) $data['toggle_open']);
    }

    /**
     * Last User logins
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionLastLogins()
    {
        return UserLogin::find()->select(['user_id', 'max(timestamp_create) as maxdate'])->joinWith(['user' => function ($q) {
            $q->select(['id', 'firstname', 'lastname']);
        }])->limit(10)->groupBy(['user_id'])->orderBy(['maxdate' => SORT_DESC])->asArray()->all();
    }
}
