<?php

namespace admintests\admin\commands;

use Yii;
use luya\admin\commands\CrudController;
use admintests\AdminTestCase;

class CrudControllerTest extends AdminTestCase
{
    public function testFindModelFolderIsModelFolderAvailable()
    {
        $ctrl = new CrudController('id', Yii::$app);
    
        $testShema = Yii::$app->db->getTableSchema('admin_user', true);
        $ctrl->moduleName = 'crudmodulefolderadmin';
        
        
        $ctrl->ensureBasePathAndNamespace();
        
        $this->assertNotEquals($ctrl->basePath, $ctrl->modelBasePath);
        $this->assertNotEquals($ctrl->namespace, $ctrl->modelNamespace);
    }
    
    public function testAssertsion()
    {
        $ctrl = new CrudController('id', Yii::$app);
        
        $testShema = Yii::$app->db->getTableSchema('admin_user', true);
        
        $this->assertNotNull($testShema);
        
        $this->assertSame(7, count($ctrl->generateRules($testShema)));
        $this->assertSame(14, count($ctrl->generateLabels($testShema)));
        
        $tpl = <<<'EOT'
<?php

namespace file\namespace;

/**
 * Test Model.
 * 
 * File has been created with `crud/create` command on LUYA version 1.0.0. 
 */
class TestModel extends \luya\admin\ngrest\base\Api
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = '\path\to\model';
}
EOT;
        
        $this->assertSame($tpl, $ctrl->generateApiContent('file\\namespace', 'TestModel', '\\path\\to\\model'));
        
        $tpl2 = <<<'EOT'
<?php

namespace file\namespace;

/**
 * Test Model.
 * 
 * File has been created with `crud/create` command on LUYA version 1.0.0. 
 */
class TestModel extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
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
 * Test Model.
 * 
 * File has been created with `crud/create` command on LUYA version 1.0.0. 
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
 * @property string $cookie_token
 */
class TestModel extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public $i18n = ['firstname', 'lastname', 'email', 'password', 'password_salt', 'auth_token', 'secure_token', 'settings', 'cookie_token'];

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
    public static function ngRestApiEndpoint()
    {
        return 'api-endpoint-name';
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
            'cookie_token' => Yii::t('app', 'Cookie Token'),
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
            [['firstname', 'lastname', 'password', 'password_salt', 'auth_token', 'cookie_token'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 120],
            [['secure_token'], 'string', 'max' => 40],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['firstname', 'lastname', 'email', 'password', 'password_salt', 'auth_token', 'secure_token', 'settings', 'cookie_token'];
    }

    /**
     * @inheritdoc
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
            'cookie_token' => 'text',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['firstname', 'lastname', 'title', 'email', 'password', 'password_salt', 'auth_token', 'is_deleted', 'secure_token', 'secure_token_timestamp', 'force_reload', 'settings', 'cookie_token']],
            [['create', 'update'], ['firstname', 'lastname', 'title', 'email', 'password', 'password_salt', 'auth_token', 'is_deleted', 'secure_token', 'secure_token_timestamp', 'force_reload', 'settings', 'cookie_token']],
            ['delete', false],
        ];
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
 * Test Model.
 * 
 * File has been created with `crud/create` command on LUYA version 1.0.0. 
 *
 * @property integer $id
 * @property string $name
 * @property string $short_code
 * @property smallint $is_default
 * @property smallint $is_deleted
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
    public static function ngRestApiEndpoint()
    {
        return 'api-endpoint-name';
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
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_default', 'is_deleted'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['short_code'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['name', 'short_code'];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'short_code' => 'text',
            'is_default' => 'number',
            'is_deleted' => 'number',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['name', 'short_code', 'is_default', 'is_deleted']],
            [['create', 'update'], ['name', 'short_code', 'is_default', 'is_deleted']],
            ['delete', false],
        ];
    }
}
EOT;
        $this->assertSame($model, $c);
    }
}
