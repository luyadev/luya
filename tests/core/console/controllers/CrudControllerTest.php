<?php

namespace luyatests\core\console\controllers;

use Yii;
use luyatests\LuyaConsoleTestCase;
use luya\console\commands\CrudController;

class CrudControllerTest extends LuyaConsoleTestCase
{
    public function testAssertsion()
    {
        $ctrl = new CrudController('id', Yii::$app);
        
        $testShema = Yii::$app->db->getTableSchema('admin_user', true);
        
        $this->assertNotNull($testShema);
        
        $this->assertSame(7, count($ctrl->generateRules($testShema)));
        $this->assertSame(13, count($ctrl->generateLabels($testShema)));
        
        $tpl = <<<'EOT'
<?php

namespace file\namespace;

/**
 * NgRest API created with LUYA Version 1.0.0-RC2-dev.
 */
class TestModel extends \luya\admin\ngrest\base\Api
{
    /**
     * @var string $modelClass The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = '\path\to\model';
}
EOT;
        
        $this->assertSame($tpl, $ctrl->generateApiContent('file\\namespace', 'TestModel', '\\path\\to\\model'));
        
        $tpl2 = <<<'EOT'
<?php

namespace file\namespace;

/**
 * NgRest Controller created with LUYA Version 1.0.0-RC2-dev.
 */
class TestModel extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string $modelClass The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = '\path\to\model';
}
EOT;
        $this->assertSame($tpl2, $ctrl->generateControllerContent('file\\namespace', 'TestModel', '\\path\\to\\model'));
        
        
        $model = <<<'EOT'
<?php

namespace file\namespace;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * NgRest Model created with LUYA Version 1.0.0-RC2-dev.
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property smallint $title
 * @property string $email
 * @property string $password
 * @property string $password_salt
 * @property string $auth_token
 * @property smallint $is_deleted
 * @property string $secure_token
 * @property integer $secure_token_timestamp
 * @property smallint $force_reload
 * @property text $settings
 */
class TestModel extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user';
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'title' => Yii::t('app', 'Title'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'password_salt' => Yii::t('app', 'Password Salt'),
            'auth_token' => Yii::t('app', 'Auth Token'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'secure_token' => Yii::t('app', 'Secure Token'),
            'secure_token_timestamp' => Yii::t('app', 'Secure Token Timestamp'),
            'force_reload' => Yii::t('app', 'Force Reload'),
            'settings' => Yii::t('app', 'Settings'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'is_deleted', 'secure_token_timestamp', 'force_reload'], 'integer'],
            [['email'], 'required'],
            [['settings'], 'string'],
            [['firstname', 'lastname', 'password', 'password_salt', 'auth_token'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 120],
            [['secure_token'], 'string', 'max' => 40],
            [['email'], 'unique'],
        ];
    }

    /**
     * @var An array containing all fields which should be transformed to multilingual fields and stored as json in the database.
     */
    public $i18n = ['firstname', 'lastname', 'email', 'password', 'password_salt', 'auth_token', 'secure_token', 'settings'];

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['restcreate'] = ['firstname', 'lastname', 'title', 'email', 'password', 'password_salt', 'auth_token', 'is_deleted', 'secure_token', 'secure_token_timestamp', 'force_reload', 'settings'];
        $scenarios['restupdate'] = ['firstname', 'lastname', 'title', 'email', 'password', 'password_salt', 'auth_token', 'is_deleted', 'secure_token', 'secure_token_timestamp', 'force_reload', 'settings'];
        return $scenarios;
    }
    
    /**
     * @return array An array containing all field which can be lookedup during the admin search process.
     */
    public function genericSearchFields()
    {
        return ['firstname', 'lastname', 'email', 'password', 'password_salt', 'auth_token', 'secure_token', 'settings'];
    }
    
    /**
     * @return string Defines the api endpoint for the angular calls
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-endpoint-name';
    }
    
    /**
     * @return array An array define the field types of each field
     */
    public function ngRestAttributeTypes()
    {
        return [
            'firstname' => 'text',
            'lastname' => 'text',
            'title' => 'number',
            'email' => 'text',
            'password' => 'text',
            'password_salt' => 'text',
            'auth_token' => 'text',
            'is_deleted' => 'number',
            'secure_token' => 'text',
            'secure_token_timestamp' => 'number',
            'force_reload' => 'number',
            'settings' => 'textarea',
        ];
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
        $this->ngRestConfigDefine($config, 'list', ['firstname', 'lastname', 'title', 'email', 'password', 'password_salt', 'auth_token', 'is_deleted', 'secure_token', 'secure_token_timestamp', 'force_reload', 'settings']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['firstname', 'lastname', 'title', 'email', 'password', 'password_salt', 'auth_token', 'is_deleted', 'secure_token', 'secure_token_timestamp', 'force_reload', 'settings']);
        
        // enable or disable ability to delete;
        $config->delete = false; 
        
        return $config;
    }
}
EOT;
        $c = $ctrl->generateModelContent(
            'file\\namespace',
            'TestModel',
            'api-endpoint-name',
            Yii::$app->db->getTableSchema('admin_user', true),
        	true
        );
        $this->assertSame($model, $c);
        
		$sum = <<<'EOT'
public $apis = [
    'api-endpoit-name' => '\path\to\api\Model',
];

public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))
        ->node('AdminUser', 'extension')
            ->group('Group')
                ->itemApi('AdminUser', 'module/admin-user/index', 'label', 'api-endpoit-name');
}
EOT;
        $this->assertSame($sum, $ctrl->generateBuildSummery('api-endpoit-name', '\\path\\to\\api\\Model', 'AdminUser', 'module/admin-user/index'));
        
    }
    
    public function testModelWithoutI18n()
    {
        $ctrl = new CrudController('id', Yii::$app);
        
        $c = $ctrl->generateModelContent(
            'file\\namespace',
            'TestModel',
            'api-endpoint-name',
            Yii::$app->db->getTableSchema('admin_lang', true),
            false
        );
        
        $model = <<<'EOT'
<?php

namespace file\namespace;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * NgRest Model created with LUYA Version 1.0.0-RC2-dev.
 *
 * @property integer $id
 * @property string $name
 * @property string $short_code
 * @property smallint $is_default
 */
class TestModel extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_lang';
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'short_code' => Yii::t('app', 'Short Code'),
            'is_default' => Yii::t('app', 'Is Default'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_default'], 'integer'],
            [['name', 'short_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['restcreate'] = ['name', 'short_code', 'is_default'];
        $scenarios['restupdate'] = ['name', 'short_code', 'is_default'];
        return $scenarios;
    }
    
    /**
     * @return array An array containing all field which can be lookedup during the admin search process.
     */
    public function genericSearchFields()
    {
        return ['name', 'short_code'];
    }
    
    /**
     * @return string Defines the api endpoint for the angular calls
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-endpoint-name';
    }
    
    /**
     * @return array An array define the field types of each field
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'short_code' => 'text',
            'is_default' => 'number',
        ];
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
        $this->ngRestConfigDefine($config, 'list', ['name', 'short_code', 'is_default']);
        $this->ngRestConfigDefine($config, ['create', 'update'], ['name', 'short_code', 'is_default']);
        
        // enable or disable ability to delete;
        $config->delete = false; 
        
        return $config;
    }
}
EOT;
        $this->assertSame($model, $c);
    }
}