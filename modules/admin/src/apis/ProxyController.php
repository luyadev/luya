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

/**
 * Proxy API.
 * 
 * How the data is prepared:
 * 
 * 1. All Tables
 * 2. Table request estimated.
 * 3.
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
		
		// @TODO make configurable in machine config?!
		$rowsPerRequest = $this->module->proxyRowsPerRequest;
		
		$config = [
			'rowsPerRequest' => $rowsPerRequest,
			'tables' => [],
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
				'offset_request_count' => 0,
			];
		}
		
		
		$buildToken = Yii::$app->security->generateRandomString(16);
		
		$build = new ProxyBuild();
		$build->attributes = [
			'machine_id' => $machine->id,
			'timestamp' => time(),
			'build_token' => $buildToken,
			'config' => Json::encode($config),
			'is_complet' => 0,
			'expiration_time' => time() + (60*10) // 10 minutes valid
		];
		
		if ($build->save()) {
			return [
				'providerUrl' => Url::base(true) . '/admin/api-admin-proxy/data-provider',
				'requestCloseUrl' => Url::base(true) . '/admin/api-admin-proxy/close',
				'buildToken' => $buildToken,
				'config' => $config,
			];
		}
		
		return $build->getErrors();
	}
	
	public function actionDataProvider($buildToken, $table, $offset)
	{
		$build = ProxyBuild::findOne(['build_token' => $buildToken, 'is_complet' => 0]);
		
		if (!$build) {
			throw new ForbiddenHttpException("Unable to find build from token.");
		}
		
		if (time() > $build->expiration_time) {
			throw new ForbiddenHttpException("The expiration as been exceeded.");
		}
		
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
	
	public function actionClose($buildToken)
	{
		$build = ProxyBuild::findOne(['build_token' => $buildToken, 'is_complet' => 0]);
		
		if (!$build) {
			throw new ForbiddenHttpException("Unable to find build from token.");
		}
		
		$build->updateAttributes(['is_complet' => 1]);
		
	}
}