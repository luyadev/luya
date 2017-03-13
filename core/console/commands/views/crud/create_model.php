<?php
echo "<?php\n";
?>

namespace <?= $namespace; ?>;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * <?= $alias; ?>.
 * 
 * <?=$luyaVersion; ?> 
 *
<?php foreach ($properties as $name => $type): ?> * @property <?= $type; ?> $<?= $name . PHP_EOL; ?>
<?php endforeach;?>
 */
class <?= $className; ?> extends NgRestModel
{
<?php if ($i18nFields): ?>
    /**
     * @inheritdoc
     */
    public $i18n = ['<?= implode("', '", $textFields); ?>'];

<?php endif;?>
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
    public static function ngRestApiEndpoint()
    {
        return '<?= $apiEndpoint; ?>';
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
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['<?= implode("', '", $textFields); ?>'];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
        <?php foreach ($ngrestFieldConfig as $name => $type): ?>
    '<?=$name; ?>' => '<?= $type;?>',
        <?php endforeach; ?>];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['<?= implode($fields, "', '"); ?>']],
            [['create', 'update'], ['<?= implode($fields, "', '"); ?>']],
            ['delete', false],
        ];
    }
}