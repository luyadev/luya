<?php

namespace luya\admin\models;

use yii\helpers\Json;
use yii\base\Arrayable;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\Module;
use luya\admin\aws\DetailViewActiveWindow;

/**
 * Logger to store information when working in controllers and actions.
 *
 * Sometimes its usefull to trace data from an action or controller in order to find out what happens an critical areas runing trough the system.
 *
 * An example of how to use the logger inside an order action:
 *
 * ```php
 * public function actionPaymentOrder($id)
 * {
 *     Logger::info('loading the payment model: ' . $id);
 *
 *     $model = MyModel::findOne($id);
 *
 *     if (!$model) {
 *         Logger::error('Unable to find the model id: ' . $id);
 *         throw new \Exception("abort");
 *     }
 *
 *     if ($model->amount < 0) {
 *         Logger::warning('Maybe something is wrong with model is amount is less then 0');
 *     }
 *
 *     if ($model->save()) {
 *         Logger::success("The model has been saved and validatet successfull");
 *     }
 * }
 * ```
 *
 * If there are multiple log informations on the same site and you like to seperate them use the group attribute.
 *
 * ```php
 * public function actionLogin()
 * {
 *     Yii::$app->user->login();
 *     Logger('User is logging in', 'user');
 *
 *     Yii::$app->user->addToBasket('Product 1');
 *     Logger('Add Product to users Cart', 'basket');
 *
 *     Logger('Redirect the user to basket', 'user');
 *     Yii::$app->user->redirect();
 * }
 * ```
 *
 * @property integer $id
 * @property integer $time
 * @property string $message
 * @property integer $type
 * @property string $trace_file
 * @property string $trace_line
 * @property string $trace_function
 * @property string $trace_function_args
 * @property string $get
 * @property string $post
 * @property string $session
 * @property string $server
 * @property string $group_identifier If provided the group_identifier is used to group multiple logging informations into one trace in order to see what messages should be display togher (trace behavior).
 * @property integer $group_identifier_index
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Logger extends NgRestModel
{
    /**
     * @var integer Type level info.
     */
    const TYPE_INFO = 1;
    
    /**
     * @var integer Type level warning.
     */
    const TYPE_WARNING = 2;
    
    /**
     * @var integer Type level error.
     */
    const TYPE_ERROR = 3;
    
    /**
     * @var integer Type level success.
     */
    const TYPE_SUCCESS = 4;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_logger';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-admin-logger';
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'time' => 'datetime',
            'message' => 'text',
            'group_identifier' => 'text',
            'group_identifier_index' => 'number',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestExtraAttributeTypes()
    {
        return [
            'typeBadge' => 'html',
        ];
    }
    
    /**
     * Get the html badge for a status type in order to display inside the admin module.
     *
     * @return string Type value evaluated as a badge.
     */
    public function getTypeBadge()
    {
        switch ($this->type) {
            case self::TYPE_INFO:
                return '<span class="badge badge-info">info</span>';
            case self::TYPE_WARNING:
                return '<span class="badge badge-warning">Warning</span>';
            case self::TYPE_ERROR:
                return '<span class="badge badge-danger">Error</span>';
            case self::TYPE_SUCCESS:
                return '<span class="badge badge-success">success</span>';
        }
    }
    
    public function ngRestGroupByField()
    {
        return 'group_identifier';
    }
    
    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['typeBadge'];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestConfig($config)
    {
        $config->aw->load([
            'class' => DetailViewActiveWindow::className(),
            'attributes' => [
                'id',
                'time:datetime',
                'message',
                'typeBadge:html:Type',
                'trace_file',
                'trace_line',
                'trace_function',
                'trace_function_args',
                'get:ntext',
                'post:ntext',
                'session:ntext',
                'server:ntext',
            ],
        ]);
        $this->ngRestConfigDefine($config, ['list'], ['message', 'typeBadge', 'time', 'group_identifier', 'group_identifier_index']);
        $config->delete = true;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'message', 'type'], 'required'],
            [['time', 'type', 'group_identifier_index'], 'integer'],
            [['message', 'get', 'post', 'session', 'server', 'group_identifier'], 'string'],
            [['trace_file', 'trace_line', 'trace_function', 'trace_function_args'], 'safe'],
        ];
    }

    private static $identiferIndex = [];

    private static $requestIdentifier;

    /**
     * Generate request identifier.
     *
     * @return string
     */
    private static function getRequestIdentifier()
    {
        if (self::$requestIdentifier === null) {
            self::$requestIdentifier = uniqid('logger', true);
        }
        
        return self::$requestIdentifier;
    }
    
    /**
     * Get array index based on identifiers.
     *
     * @param unknown $message
     * @param unknown $groupIdentifier
     * @return string[]|mixed[]
     */
    private static function getHashArray($message, $groupIdentifier)
    {
        $hash = md5(static::getRequestIdentifier() . Json::encode((array) $groupIdentifier));
        if (isset(self::$identiferIndex[$hash])) {
            self::$identiferIndex[$hash]++;
        } else {
            self::$identiferIndex[$hash] = 1;
        }
    
        $hashIndex =  self::$identiferIndex[$hash];
    
        return [
            'hash' => $hash,
            'index' => $hashIndex,
        ];
    }
    
    /**
     * Internal generate log message.
     *
     * @param unknown $type
     * @param unknown $message
     * @param unknown $trace
     * @param unknown $groupIdentifier
     * @return boolean
     */
    private static function log($type, $message, $trace, $groupIdentifier)
    {
        $hashArray = static::getHashArray($message, $groupIdentifier);
        
        $file = 'unknown';
        $line = 'unknown';
        $fn = 'unknown';
        $fnArgs = [];
        
        if (isset($trace[0])) {
            $file = !isset($trace[0]['file']) ? : $trace[0]['file'];
            $line = !isset($trace[0]['line']) ? : $trace[0]['line'];
            $fn = !isset($trace[0]['function']) ? : $trace[0]['function'];
            $fnArgs = !isset($trace[0]['args']) ? : $trace[0]['args'];
        }
        
        if (isset($trace[1])) {
            $fn = !isset($trace[1]['function']) ? : $trace[1]['function'];
            $fnArgs = !isset($trace[1]['args']) ? : $trace[1]['args'];
        }
        
        if ($message instanceof Arrayable) {
            $message = $message->toArray();
        }
        
        $model = new self();
        $model->attributes = [
            'time' => time(),
            'message' => is_array($message) ? Json::encode($message) : $message,
            'type' => $type,
            'trace_file' => $file,
            'trace_line' => $line,
            'trace_function' => $fn,
            'trace_function_args' => Json::encode($fnArgs),
            'get' => (isset($_GET)) ? Json::encode($_GET) : '{}',
            'post' => (isset($_POST)) ? Json::encode($_POST) : '{}',
            'session' => (isset($_SESSION)) ? Json::encode($_SESSION) : '{}',
            'server' => (isset($_SERVER)) ? Json::encode($_SERVER) : '{}',
            'group_identifier' => $hashArray['hash'],
            'group_identifier_index' => $hashArray['index'],
        ];
        
        return $model->save(false);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('model_pk_id'),
            'time' => Module::t('model_logger_time'),
            'message' => Module::t('model_logger_message'),
            'type' => Module::t('model_logger_type'),
            'trace_file' => Module::t('model_logger_trace_file'),
            'trace_line' => Module::t('model_logger_trace_line'),
            'trace_function' => Module::t('model_logger_trace_function'),
            'trace_function_args' => Module::t('model_logger_trace_function_args'),
            'get' => Module::t('model_logger_get'),
            'post' => Module::t('model_logger_post'),
            'session' => Module::t('model_logger_session'),
            'server' => Module::t('model_logger_server'),
            'group_identifier' => Module::t('model_logger_group_identifier'),
            'group_identifier_index' => Module::t('model_logger_group_identifier_index'),
            'typeBadge' => Module::t('model_logger_badgetype'),
        ];
    }
    
    /**
     * Log a success message.
     *
     * @param string $message The message to log for this current request event.
     * @param string $groupIdentifier If multiple logger events are in the same action and you want to seperate them, define an additional group identifier.
     * @return boolean
     */
    public static function success($message, $groupIdentifier = null)
    {
        return static::log(self::TYPE_SUCCESS, $message, debug_backtrace(false, 2), $groupIdentifier);
    }

    /**
     * Log an error message.
     *
     * @param string $message The message to log for this current request event.
     * @param string $groupIdentifier If multiple logger events are in the same action and you want to seperate them, define an additional group identifier.
     * @return boolean
     */
    public static function error($message, $groupIdentifier = null)
    {
        return static::log(self::TYPE_ERROR, $message, debug_backtrace(false, 2), $groupIdentifier);
    }
    
    /**
     * Log an info message.
     *
     * @param string $message The message to log for this current request event.
     * @param string $groupIdentifier If multiple logger events are in the same action and you want to seperate them, define an additional group identifier.
     * @return boolean
     */
    public static function info($message, $groupIdentifier = null)
    {
        return static::log(self::TYPE_INFO, $message, debug_backtrace(false, 2), $groupIdentifier);
    }
    
    /**
     * Log a warning message.
     *
     * @param string $message The message to log for this current request event.
     * @param string $groupIdentifier If multiple logger events are in the same action and you want to seperate them, define an additional group identifier.
     * @return boolean
     */
    public static function warning($message, $groupIdentifier = null)
    {
        return static::log(self::TYPE_WARNING, $message, debug_backtrace(false, 2), $groupIdentifier);
    }
}
