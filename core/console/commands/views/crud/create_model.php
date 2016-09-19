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

namespace <?= $namespace; ?>;

use Yii;

/**
 * NgRest Model created at <?= date("d.m.Y H:i"); ?> on LUYA Version <?= $luyaVersion; ?>.
 *
<?php foreach ($properties as $name => $type): ?> * @property <?= $type; ?> $<?= $name . PHP_EOL; ?>
<?php endforeach;?>
 */
<?php if (!$extended): ?>abstract <?php endif; ?>class <?= $className; ?> extends \luya\admin\ngrest\base\NgRestModel
{
    <?php if ($extended): ?>
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
        <?php foreach ($allFieldNames as $name): ?>
    '<?= $name; ?>' => Yii::t('app', '<?= \yii\helpers\Inflector::humanize($name); ?>'),
        <?php endforeach; ?>];
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
    <?php endif; ?>/**
     * @var An array containing all fields which should be transformed to multilingual fields and stored as json in the database.
     */
    public $i18n = ['<?= implode("', '", $textFields); ?>'];
    
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
        return ['<?= implode("', '", $textFields); ?>'];
    }
    
    /**
     * @return string Defines the api endpoint for the angular calls
     */
    public static function ngRestApiEndpoint()
    {
        return '<?= $apiEndpoint; ?>';
    }
    
    /**
     * @return array An array define the field types of each field
     */
    public function ngrestAttributeTypes()
    {
        return [
        <?php foreach ($fieldConfigs as $name => $type): ?>
    '<?=$name; ?>' => '<?= $type;?>',
        <?php endforeach; ?>];
    }
    
    /**
     * Define the NgRestConfig for this model with the ConfigBuilder object.
     *
     * @param \luya\admin\ngrest\ConfigBuilder $config The current active config builder object.
     * @return \luya\admin\ngrest\ConfigBuilder
     */
    public function ngRestConfig($config)
    {
        // define fields for types based from ngrestAttributeTypes
        $this->ngRestConfigDefine($config, 'list', ['<?= implode($fieldNames, "', '"); ?>']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['<?= implode($fieldNames, "', '"); ?>']);
        
        // enable or disable ability to delete;
        $config->delete = false; 
        
        return $config;
    }
}
