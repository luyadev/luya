<?php

namespace luyatests\core\helpers;

use Yii;
use luyatests\LuyaWebTestCase;
use luya\helpers\ExportHelper;
use yii\db\ActiveRecord;

class CsvModelStub extends ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->sqllite;
    }

    public static function tableName()
    {
        return 'csvmodelstub';
    }
    
    public function rules()
    {
        return [
            [['id', 'name'], 'safe'],
        ];
    }
}

class ExportHelperTest extends LuyaWebTestCase
{
    private function getArray()
    {
        return [
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane'],
        ];
    }
    
    private function initActiveRecord()
    {
        Yii::$app->sqllite->createCommand()->createTable('csvmodelstub', [
            'id' => 'INT(11) PRIMARY KEY',
            'name' => 'varchar(120)'])->execute();
    }
    
    public function testCsvArrayExport()
    {
        $this->assertEquals('"id","name"'.PHP_EOL.'"1","John"'.PHP_EOL.'"2","Jane"'. PHP_EOL, ExportHelper::csv($this->getArray()));
    }
    
    public function testCsvArrayExportWithProperties()
    {
        $this->assertEquals('"id"'.PHP_EOL.'"1"'.PHP_EOL.'"2"'. PHP_EOL, ExportHelper::csv($this->getArray(), ['id']));
    }
    
    public function testCsvArrayExportWithPropertiesAndDifferentArrangedSortedColumns()
    {
        $this->assertEquals('"id","name"'.PHP_EOL.'"1","John"'.PHP_EOL.'"2","Jane"'. PHP_EOL, ExportHelper::csv($this->getArray(), ['name', 'id']));
    }
    
    public function testCsvArrayExportNoHeader()
    {
        $this->assertEquals('"1","John"'.PHP_EOL.'"2","Jane"'. PHP_EOL, ExportHelper::csv($this->getArray(), [], false));
    }
    
    public function testCsvArrayExportWithPropertiesNoHeader()
    {
        $this->assertEquals('"1"'.PHP_EOL.'"2"'. PHP_EOL, ExportHelper::csv($this->getArray(), ['id'], false));
    }

    public function testActiveRecordCsv()
    {
        $this->initActiveRecord();
     
        foreach ($this->getArray() as $item) {
            $m = new CsvModelStub();
            $m->attributes = $item;
            $m->save();
        }

        // active query find
        $this->assertEquals('"Id","Name"'.PHP_EOL.'"1","John"'.PHP_EOL.'"2","Jane"'. PHP_EOL, ExportHelper::csv(CsvModelStub::find()));
        $this->assertEquals('"1","John"'.PHP_EOL.'"2","Jane"'. PHP_EOL, ExportHelper::csv(CsvModelStub::find(), [], false));
        $this->assertEquals('"1"'.PHP_EOL.'"2"'. PHP_EOL, ExportHelper::csv(CsvModelStub::find(), ['id'], false));
        $this->assertEquals('"Id"'.PHP_EOL.'"1"'.PHP_EOL.'"2"'. PHP_EOL, ExportHelper::csv(CsvModelStub::find(), ['id']));
    }
    
    public function testException()
    {
        $this->expectException("luya\Exception");
        ExportHelper::csv('foobarstring');
    }

    public function testXlsArrayExport()
    {
        $this->assertSame("---", ExportHelper::xlsx($this->getArray(), ['id'], false));
    }
}
