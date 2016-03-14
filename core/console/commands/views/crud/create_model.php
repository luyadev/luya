<?php
/**
 * @var $className
 * @var $modelClass
 * @var $namespace
 * @var $luyaVersion
 * @var $sqlTable
 * @var $fieldNames
 * @var $allFieldNames
 * @var $textFields
 * @var $textareaFields
 * @var $i18n
 */

echo "<?php\n";
?>

namespace <?php echo $namespace; ?>;

use Yii;

/**
 * NgRest Model created at <?php echo date("d.m.Y H:i"); ?> on LUYA Version <?php echo $luyaVersion; ?>.
 */
<? if (!$extended): ?>abstract <?endif;?>class <?php echo $className; ?> extends \admin\ngrest\base\Model
{
    <? if($extended): ?>
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $sqlTable; ?>';
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        <? foreach($allFieldNames as $name): ?>
    '<?= $name; ?>' => Yii::t('app', '<?= \yii\helpers\Inflector::humanize($name); ?>'),
        <? endforeach;?>];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             [['<?= implode($fieldNames, "', '"); ?>'], 'required'],
        ];
    }
    
    // ngrest base model methods
    <? endif; ?>/**
     * @var An array containing all fields which should be transformed to multilingual fields and stored as json in the database.
     */
    public $i18n = ['<?= implode("', '", $i18n); ?>'];
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['restcreate'] = ['<?= implode("', '", $allFieldNames); ?>'];
        $scenarios['restupdate'] = ['<?= implode("', '", $allFieldNames); ?>'];
        return $scenarios;
    }
    
    /**
     * @return array An array containing all field which can be lookedup during the admin search process.
     */
    public function genericSearchFields()
    {
        return ['<?= implode("', '", $fieldNames); ?>'];
    }
    
    /**
     * @return string Defines the api endpoint for the angular calls
     */
    public function ngRestApiEndpoint()
    {
        return '<?= $apiEndpoint; ?>';
    }
    
    /**
     * @return array An array define the field types of each field
     */
    public function ngrestAttributeTypes()
    {
        return [
        <? foreach($fieldConfigs as $name => $type): ?>
    '<?=$name; ?>' => '<?= $type;?>',
        <?endforeach;?>];
    }
    
    /**
     * @return \admin\ngrest\Config the configured ngrest object
     */
    public function ngRestConfig($config)
    {
        // define fields for types based from ngrestAttributeTypes
        $this->ngRestConfigDefine($config, 'list', ['<?= implode($fieldNames, "', '"); ?>']);
        $this->ngRestConfigDefine($config, 'create', ['<?= implode($fieldNames, "', '"); ?>']);
        $this->ngRestConfigDefine($config, 'update', ['<?= implode($fieldNames, "', '"); ?>']);
        
        // enable or disable ability to delete;
        $config->delete = false; 
        
        return $config;
    }
}
