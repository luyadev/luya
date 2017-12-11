<?php

namespace luya\admin\proxy;

use Yii;
use Curl\Curl;
use yii\helpers\Json;
use yii\helpers\Console;
use yii\base\BaseObject;

/**
 * Admin Proxy comands Sync Database.
 *
 * @property \yii\db\TableSchema $schema Schema object
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ClientTable extends BaseObject
{
    private $_data;
    
    /**
     * @var \luya\admin\proxy\ClientBuild
     */
    public $build;
    
    /**
     *
     * @param ClientBuild $build
     * @param array $data
     * @param array $config
     */
    public function __construct(ClientBuild $build, array $data, array $config = [])
    {
        $this->build = $build;
        $this->_data = $data;
        parent::__construct($config);
    }
    
    private $_schema;
    
    public function getSchema()
    {
        if ($this->_schema === null) {
            $this->_schema = Yii::$app->db->getTableSchema($this->getName());
        }
        
        return $this->_schema;
    }
    
    public function getColumns()
    {
        return $this->schema->getColumnNames();
    }
    
    protected function cleanUpMatchRow($row)
    {
        $data = [];
        foreach ($row as $key => $item) {
            foreach ($item as $field => $value) {
                if (in_array($field, $this->getColumns())) {
                    $data[$key][$field] = $value;
                }
            }
        }
        
        return $data;
    }
    
    protected function cleanUpBatchInsertFields($fields)
    {
        $data = [];
        foreach ($fields as $field) {
            if (in_array($field, $this->getColumns())) {
                $data[] = $field;
            }
        }
        
        return $data;
    }
    
    public function getPks()
    {
        return $this->_data['pks'];
    }
    
    public function getName()
    {
        return $this->_data['name'];
    }
    
    public function getRows()
    {
        return $this->_data['rows'];
    }
    
    public function getFields()
    {
        return $this->_data['fields'];
    }
    
    public function getOffsetTotal()
    {
        return $this->_data['offset_total'];
    }
    
    public function isComplet()
    {
        return $this->getRows() == count($this->getContentRows());
    }
    
    private $_contentRows;
    
    public function getContentRows()
    {
        if ($this->_contentRows === null) {
            $data = [];
            
            Console::startProgress(0, $this->getOffsetTotal(), 'Fetch: ' . $this->getName() . ' ');
            
            $progress = 1;
            for ($i=0; $i<$this->getOffsetTotal(); $i++) {
                $requestData = $this->request($i);
                
                if (!$requestData) {
                    continue;
                }
                
                $data = array_merge($requestData, $data);
                gc_collect_cycles();
                Console::updateProgress($progress++, $this->getOffsetTotal());
            }
            
            Console::endProgress();
            $this->_contentRows = $data;
        }
        
        return $this->_contentRows;
    }
    
    public function syncData()
    {
        Yii::$app->db->createCommand()->truncateTable($this->getName())->execute();
        
        $rows = $this->getContentRows();

        $chunks = array_chunk($rows, 25);
        
        foreach ($chunks as $match) {
            Yii::$app->db->createCommand()->batchInsert($this->getName(), $this->cleanUpBatchInsertFields($this->getFields()), $this->cleanUpMatchRow($match))->execute();
        }
    }
    
    private function request($offset)
    {
        $curl = new Curl();
        $curl->get($this->build->requestUrl, ['machine' => $this->build->machineIdentifier, 'buildToken' => $this->build->buildToken, 'table' => $this->name, 'offset' => $offset]);
        
        if (!$curl->error) {
            $response = Json::decode($curl->response);
            $curl->close();
            unset($curl);
            return $response;
        } else {
            $this->build->command->outputError("Error while collecting data from server: " . $curl->error_message);
        }
        
        return false;
    }
}
