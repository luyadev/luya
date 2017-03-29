<?php

namespace luya\admin\apis;

use Yii;
use luya\rest\Controller;
use luya\admin\models\ProxyMachine;
use yii\web\ForbiddenHttpException;
use yii\db\Query;
use luya\admin\models\ProxyBuild;
use yii\helpers\Json;
use luya\helpers\Url;
use luya\admin\models\StorageFile;

/**
 * Proxy API.
 *
 * How the data is prepared:
 *
 * 1. Foreach all tables
 * 2. Ignore the $ingoreTables list
 * 3. Table request estimated data write to $config
 * 4. Generate Build.
 * 5. Send build identifier to the client.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ProxyController extends Controller
{
    protected $ignoreTables = [
        'admin_proxy_build', 'admin_proxy_machine', 'migration', 'admin_config',
    ];
    
    public function actionIndex($identifier, $token)
    {
        $machine = ProxyMachine::findOne(['identifier' => $identifier, 'is_deleted' => 0]);
        
        if (!$machine) {
            throw new ForbiddenHttpException("Unable to acccess the proxy api.");
        }
        
        if (sha1($machine->access_token) !== $token) {
            throw new ForbiddenHttpException("Unable to acccess the proxy api due to invalid token.");
        }
        
        $rowsPerRequest = $this->module->proxyRowsPerRequest;
        
        $config = [
            'rowsPerRequest' => $rowsPerRequest,
            'tables' => [],
            'storageFilesCount' => StorageFile::find()->count(),
        ];
        
        foreach (Yii::$app->db->schema->tableNames as $table) {
            if (in_array($table, $this->ignoreTables)) {
                continue;
            }
            
            $schema = Yii::$app->db->getTableSchema($table);
            $rows = (new Query())->from($table)->count();
            $config['tables'][$table] = [
                'pks' => $schema->primaryKey,
                'name' => $table,
                'rows' => $rows,
                'fields' => $schema->columnNames,
                'offset_total' => ceil($rows/$rowsPerRequest),
            ];
        }
        
        $buildToken = Yii::$app->security->generateRandomString(16);
        
        $build = new ProxyBuild();
        $build->detachBehavior('LogBehavior');
        $build->attributes = [
            'machine_id' => $machine->id,
            'timestamp' => time(),
            'build_token' => sha1($buildToken),
            'config' => Json::encode($config),
            'is_complet' => 0,
            'expiration_time' => time() + $this->module->proxyExpirationTime
        ];
        
        if ($build->save()) {
            return [
                'providerUrl' => Url::base(true) . '/admin/api-admin-proxy/data-provider',
                'requestCloseUrl' => Url::base(true) . '/admin/api-admin-proxy/close',
                'fileProviderUrl' => Url::base(true) . '/admin/api-admin-proxy/file-provider',
                'imageProviderUrl' => Url::base(true) . '/admin/api-admin-proxy/image-provider',
                'buildToken' => $buildToken,
                'config' => $config,
            ];
        }
        
        return $build->getErrors();
    }
    
    private function ensureBuild($machine, $buildToken)
    {
        $build = ProxyBuild::findOne(['build_token' => $buildToken, 'is_complet' => 0]);
        
        if (!$build) {
            throw new ForbiddenHttpException("Unable to find a ProxyBuild for the provided token.");
        }
        
        if (time() > $build->expiration_time) {
            throw new ForbiddenHttpException("The expiration time ".date("d.m.Y H:i:s", $build->expiration_time)." has exceeded.");
        }
        
        if ($build->proxyMachine->identifier !== $machine) {
            throw new ForbiddenHttpException("Invalid machine identifier for current build.");
        }
        
        return $build;
    }
    
    public function actionDataProvider($machine, $buildToken, $table, $offset)
    {
        $build = $this->ensureBuild($machine, $buildToken);
        
        $config = $build->getTableConfig($table);
        
        $offsetNummeric = $offset * $build->rowsPerRequest;

        $query =  (new Query())
            ->select($config['fields'])
            ->from($config['name'])
            ->offset($offsetNummeric)
            ->limit($build->rowsPerRequest);
        
        if (!empty($config['pks']) && is_array($config['pks'])) {
            $orders = [];
            foreach ($config['pks'] as $pk) {
                $orders[$pk] = SORT_ASC;
            }
            $query->orderBy($orders);
        }
        
        return $query->all();
    }
    
    
    
    public function actionFileProvider($machine, $buildToken, $fileId)
    {
        $build = $this->ensureBuild($machine, $buildToken);
        
        if ($build) {
            if (!is_numeric($fileId)) {
                throw new \InvalidArgumentException("Invalid file id provided.");
            }
            
            $file = Yii::$app->storage->getFile($fileId);
            /* @var $file \luya\admin\file\Item */
            if ($file->fileExists) {
                return Yii::$app->response->sendFile($file->serverSource)->send();
            }
        }
        
        return null;
    }
    
    public function actionImageProvider($machine, $buildToken, $imageId)
    {
        $build = $this->ensureBuild($machine, $buildToken);
    
        if ($build) {
            if (!is_numeric($imageId)) {
                throw new \InvalidArgumentException("Invalid image id provided.");
            }
    
            $image = Yii::$app->storage->getImage($imageId);
            /* @var $image \luya\admin\image\Item */
            if ($image->fileExists) {
                return Yii::$app->response->sendFile($image->serverSource)->send();
            }
        }
    
        return null;
    }
    
    public function actionClose($buildToken)
    {
        $build = ProxyBuild::findOne(['build_token' => $buildToken, 'is_complet' => 0]);
        
        if (!$build) {
            throw new ForbiddenHttpException("Unable to find build from token.");
        }
        
        $build->updateAttributes(['is_complet' => 1]);
    }
}
