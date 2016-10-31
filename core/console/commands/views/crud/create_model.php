<?php
echo "<?php\n";
?>

namespace <?= $namespace; ?>;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * NgRest Model created at <?= date("d.m.Y H:i"); ?> on LUYA Version <?= $luyaVersion; ?>.
 *
<?php foreach ($properties as $name => $type): ?> * @property <?= $type; ?> $<?= $name . PHP_EOL; ?>
<?php endforeach;?>
 */
class <?= $className; ?> extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $dbTableName; ?>';
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        <?php foreach ($labels as $key => $label): ?>
    '<?= $key; ?>' => Yii::t('app', '<?=$label?>'),
        <?php endforeach; ?>];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        <?php foreach ($rules as $rule): ?>
    <?=$rule?>,
        <?php endforeach; ?>];
    }
    
    /**
     * @var An array containing all fields which should be transformed to multilingual fields and stored as json in the database.
     */
    public $i18n = ['<?= implode("', '", $textFields); ?>'];
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['restcreate'] = ['<?= implode("', '", $fields); ?>'];
        $scenarios['restupdate'] = ['<?= implode("', '", $fields); ?>'];
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
        <?php foreach ($ngrestFieldConfig as $name => $type): ?>
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
        $this->ngRestConfigDefine($config, 'list', ['<?= implode($fields, "', '"); ?>']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['<?= implode($fields, "', '"); ?>']);
        
        // enable or disable ability to delete;
        $config->delete = false; 
        
        return $config;
    }
}
