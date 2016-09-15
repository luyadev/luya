<?php

namespace luya\admin\models;

use Yii;
use yii\helpers\Json;
use yii\base\Arrayable;

/**
 * Logger to store information when working in controllers and actions.
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
 */
class Logger extends \yii\db\ActiveRecord
{
    const TYPE_NOTICE = 1;
    
    const TYPE_ERROR = 2;
    
    const TYPE_TRACE = 3;
    
    const TYPE_WARNING = 4;
    
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
    
    private static function log($type, $message, $trace, $groupIdentifier = null, $grouIdentifierIndex = 0)
    {
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
            'group_identifier' => $groupIdentifier,
            'group_identifier_index' => $grouIdentifierIndex,
        ];
        
        return $model->save(false);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'message' => 'Message',
            'type' => 'Type',
            'trace_file' => 'Trace File',
            'trace_line' => 'Trace Line',
            'trace_function' => 'Trace Function',
            'trace_function_args' => 'Trace Function Args',
            'get' => 'Get',
            'post' => 'Post',
            'session' => 'Session',
            'server' => 'Server',
            'group_identifier' => 'Group Identifier',
            'group_identifier_index' => 'Group Identifier Index',
        ];
    }
    
    public static function notice($message)
    {
        return static::log(self::TYPE_NOTICE, $message, debug_backtrace(false, 2));
    }

    public static function error($message)
    {
        return static::log(self::TYPE_ERROR, $message, debug_backtrace(false, 2));
    }
    
    public static function trace($groupIdentifier, $message)
    {
        $hash = md5(Json::encode((array) $groupIdentifier));
        if (isset(self::$identiferIndex[$hash])) {
            self::$identiferIndex[$hash]++;
        } else {
            self::$identiferIndex[$hash] = 1;
        }
        return static::log(self::TYPE_TRACE, $message, debug_backtrace(false, 2), $hash, self::$identiferIndex[$hash]);
    }
    
    public static function warning($message)
    {
        return static::log(self::TYPE_WARNING, $message, debug_backtrace(false, 2));
    }
}