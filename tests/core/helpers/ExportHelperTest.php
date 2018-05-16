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
    
    public function testCsvArrayRowTypes()
    {
        $this->assertEquals('"1","0","0","","[array]","string","1","1"'. PHP_EOL, ExportHelper::csv([
            [
                true, false, 0, null, ['bar'], 'string', 1, '1'
            ]
        ], [], false));
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

    public function testXlsArrayExportWithHeader()
    {
        $filename = tempnam('', 'xlsx_test');
        $this->saveArrayToXlsx($filename, $this->getArray(), ['id', 'name'], true);
        $this->assertSame($this->getXmlSheetContent($filename), $this->getXmlSheetContent('tests/data/export/withheader.xlsx'));
    }

    public function testXlsArrayExportWithoutHeader()
    {
        $filename = tempnam('', 'xlsx_test');
        $this->saveArrayToXlsx($filename, $this->getArray(), ['id', 'name'], false);
        $this->assertSame($this->getXmlSheetContent($filename), $this->getXmlSheetContent('tests/data/export/withoutheader.xlsx'));
    }

    protected function getXmlSheetContent($filename)
    {
        $zip = new \ZipArchive();
        $zip->open($filename);
        for ($z = 0; $z < $zip->numFiles; $z++) {
            $inside_zip_filename = $zip->getNameIndex($z);
            if (basename($inside_zip_filename) == 'sheet1.xml') {
                return $zip->getFromName($inside_zip_filename);
            }
        }
    }

    protected function saveArrayToXlsx($filename, array $input, array $keys = [], $header = true)
    {
        $string = ExportHelper::xlsx($input, $keys, $header);
        file_put_contents($filename, $string);
    }
}
