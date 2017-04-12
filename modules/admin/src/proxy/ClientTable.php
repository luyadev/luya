<?php

namespace luya\admin\proxy;

use Yii;
use yii\base\Object;
use Curl\Curl;
use yii\helpers\Json;
use yii\helpers\Console;

/**
 * @since 1.0.0
 * @var \yii\db\TableSchema $schema Schema object
 */
class ClientTable extends Object
{
    private $_data = null;
    
    /**
     * @var \luya\admin\proxy\ClientBuild
     */
    public $build = null;
    
    public function __construct(ClientBuild $build, array $data, array $config = [])
    {
        $this->build = $build;
        $this->_data = $data;
        parent::__construct($config);
    }
    
    private $_schema = null;
    
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
    
    private $_contentRows = null;
    
    public function getContentRows()
    {
        if ($this->_contentRows === null) {
            $data = [];
            
            Console::startProgress(0, $this->getOffsetTotal(), 'Fetch: ' . $this->getName() . ' ');
            
            $progress = 1;
            for ($i=0; $i<$this->getOffsetTotal(); $i++) {
                $data = array_merge($this->request($i), $data);
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
        $num = count($rows);
        $counts = ceil($num/25);

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
        }
    }
}
