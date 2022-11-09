<?php

namespace luya\traits;

use Curl\Curl;
use luya\Boot;
use luya\exceptions\WhitelistedException;
use luya\helpers\ArrayHelper;
use luya\helpers\ObjectHelper;
use luya\helpers\Url;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\Application;
use yii\web\HttpException;

/**
 * ErrorHandler trait to extend the renderException method with an api call if enabled.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
trait ErrorHandlerTrait
{
    /**
     * @var string The url of the error api without trailing slash. Make sure you have installed the error api
     * module on the requested api url (https://luya.io/guide/module/luyadev---luya-module-errorapi).
     *
     * An example when using the erroapi module, the url could look like this `https://luya.io/errorapi`.
     */
    public $api;

    /**
     * @var boolean Enable the transfer of exceptions to the defined `$api` server.
     */
    public $transferException = false;

    /**
     * @var \Curl\Curl|null The curl object from the last error api call.
     * @since 1.0.5
     */
    public $lastTransferCall;

    /**
     * @var array An array of exceptions which are whitelisted and therefore NOT TRANSFERED. Whitelisted exception
     * are basically expected application logic which does not need to report informations to the developer, as the
     * application works as expect.
     * @since 1.0.5
     */
    public $whitelist = [
        'yii\base\InvalidRouteException',
        'yii\web\NotFoundHttpException',
        'yii\web\ForbiddenHttpException',
        'yii\web\MethodNotAllowedHttpException',
        'yii\web\UnauthorizedHttpException',
        'yii\web\BadRequestHttpException',
    ];

    /**
     * @var array
     * @since 1.0.6
     */
    public $sensitiveKeys = ['password', 'pwd', 'pass', 'passwort', 'pw', 'token', 'hash', 'authorization'];

    /**
     * Send a custom message to the api server event its not related to an exception.
     *
     * Sometimes you just want to pass informations from your application, this method allows you to transfer
     * a message to the error api server.
     *
     * Example of sending a message
     *
     * ```php
     * Yii::$app->errorHandler->transferMessage('Something went wrong here!', __FILE__, __LINE__);
     * ```
     *
     * @param string $message The message you want to send to the error api server.
     * @param string $file The you are currently send the message (use __FILE__)
     * @param string $line The line you want to submit (use __LINE__)
     * @return bool|null
     */
    public function transferMessage($message, $file = __FILE__, $line = __LINE__)
    {
        return $this->apiServerSendData($this->getExceptionArray([
            'message' => $message,
            'file' => $file,
            'line' => $line,
        ]));
    }

    /**
     * Returns whether a given exception is whitelisted or not.
     *
     * If an exception is whitelisted or in the liste of whitelisted exception
     * the exception content won't be transmitted to the error api.
     *
     * @param mixed $exception
     * @return boolean Returns true if whitelisted, or false if not and can therefore be transmitted.
     * @since 1.0.21
     */
    public function isExceptionWhitelisted($exception)
    {
        if (!is_object($exception)) {
            return false;
        }

        if (ObjectHelper::isInstanceOf($exception, WhitelistedException::class, false)) {
            return true;
        }

        return ObjectHelper::isInstanceOf($exception, $this->whitelist, false);
    }

    /**
     * Send the array data to the api server.
     *
     * @param array $data The array to be sent to the server.
     * @return boolean|null true/false if data has been sent to the api successfull or not, null if the transfer is disabled.
     */
    private function apiServerSendData(array $data)
    {
        $curl = new Curl();
        $curl->setOpt(CURLOPT_CONNECTTIMEOUT, 2);
        $curl->setOpt(CURLOPT_TIMEOUT, 2);
        $curl->post(Url::ensureHttp(rtrim((string) $this->api, '/')).'/create', [
            'error_json' => Json::encode($data),
        ]);
        $this->lastTransferCall = $curl;

        return $curl->isSuccess();
    }

    /**
     * @inheritdoc
     */
    public function renderException($exception)
    {
        if ($this->transferException && !$this->isExceptionWhitelisted($exception)) {
            $this->apiServerSendData($this->getExceptionArray($exception));
        }

        return parent::renderException($exception);
    }

    /**
     * Get an readable array to transfer from an exception
     *
     * @param mixed $exception Exception object
     * @return array An array with transformed exception data
     */
    public function getExceptionArray($exception)
    {
        $_message = 'Uknonwn exception object, not instance of \Exception.';
        $_file = 'unknown';
        $_line = 0;
        $_trace = [];
        $_previousException = [];
        $_exceptionClassName = 'Unknown';

        if (is_object($exception)) {
            $_exceptionClassName = get_class($exception);
            $prev = $exception->getPrevious();

            if (!empty($prev)) {
                $_previousException = [
                    'message' => $prev->getMessage(),
                    'file' => $prev->getFile(),
                    'line' => $prev->getLine(),
                    'trace' => $this->buildTrace($prev),
                ];
            }

            $_trace = $this->buildTrace($exception);
            $_message = $exception->getMessage();
            $_file = $exception->getFile();
            $_line = $exception->getLine();
        } elseif (is_string($exception)) {
            $_message = 'exception string: ' . $exception;
        } elseif (is_array($exception)) {
            $_message = $exception['message'] ?? 'exception array dump: ' . print_r($exception, true);
            $_file = $exception['file'] ?? __FILE__;
            $_line = $exception['line'] ?? __LINE__;
        }

        $exceptionName = 'Exception';

        if ($exception instanceof Exception) {
            $exceptionName = $exception->getName();
        } elseif ($exception instanceof ErrorException) {
            $exceptionName = $exception->getName();
        }

        return [
            'message' => $_message,
            'file' => $_file,
            'line' => $_line,
            'requestUri' => $_SERVER['REQUEST_URI'] ?? null,
            'serverName' => $_SERVER['SERVER_NAME'] ?? null,
            'date' => date('d.m.Y H:i'),
            'trace' => $_trace,
            'previousException' => $_previousException,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
            'get' => isset($_GET) ? ArrayHelper::coverSensitiveValues($_GET, $this->sensitiveKeys) : [],
            'post' => isset($_POST) ? ArrayHelper::coverSensitiveValues($_POST, $this->sensitiveKeys) : [],
            'bodyParams' => Yii::$app instanceof Application ? ArrayHelper::coverSensitiveValues(Yii::$app->request->bodyParams) : [],
            'session' => isset($_SESSION) ? ArrayHelper::coverSensitiveValues($_SESSION, $this->sensitiveKeys) : [],
            'server' => isset($_SERVER) ? ArrayHelper::coverSensitiveValues($_SERVER, $this->sensitiveKeys) : [],
            // since 1.0.20
            'yii_debug' => YII_DEBUG,
            'yii_env' => YII_ENV,
            'status_code' => $exception instanceof HttpException ? $exception->statusCode : 500,
            'exception_name' => $exceptionName,
            'exception_class_name' => $_exceptionClassName,
            'php_version' => phpversion(),
            'luya_version' => Boot::VERSION,
            'yii_version' => Yii::getVersion(),
            'app_version' => Yii::$app->version,
        ];
    }

    /**
     * Build trace array from exception.
     *
     * @param object $exception
     * @return array
     */
    private function buildTrace($exception)
    {
        $_trace = [];
        foreach ($exception->getTrace() as $key => $item) {
            // if a trace entry does not contain file and/or line omit from exception as this
            // is by defintion the first stack trace entry.
            if (!isset($item['file'])) {
                $item['file'] = $exception->getFile();
            }
            if (!isset($item['line'])) {
                $item['line'] = $exception->getLine();
            }

            $_trace[$key] = $this->buildTraceItem($item);
        }

        return $_trace;
    }

    /**
     * Build the array trace item with file context.
     *
     * @param array $item
     * @return array
     */
    private function buildTraceItem(array $item)
    {
        $file = $item['file'] ?? null;
        $line = $item['line'] ?? null;
        $contextLine = null;
        $preContext = [];
        $postContext = [];

        if (!empty($file)) {
            try {
                $lineInArray = $line -1;
                // load file from path
                $fileInfo = file($file, FILE_IGNORE_NEW_LINES);
                // load file if false from real path
                if (!$fileInfo) {
                    $fileInfo = file(realpath($file), FILE_IGNORE_NEW_LINES);
                }
                if ($fileInfo && isset($fileInfo[$lineInArray])) {
                    $contextLine = $fileInfo[$lineInArray];
                }
                if ($contextLine) {
                    for ($i = 1; $i <= 6; $i++) {
                        // pre context
                        if (isset($fileInfo[$lineInArray - $i])) {
                            $preContext[] = $fileInfo[$lineInArray - $i];
                        }
                        // post context
                        if (isset($fileInfo[$i + $lineInArray])) {
                            $postContext[] = $fileInfo[$i + $lineInArray];
                        }
                    }
                    $preContext = array_reverse($preContext);
                }
                unset($fileInfo);
            } catch (\Exception $e) {
                // catch if any file load error appears
            }
        }

        return array_filter([
            'file' => $file,
            'abs_path' => realpath($file),
            'line' => $line,
            'context_line' => $contextLine,
            'pre_context' => $preContext,
            'post_context' => $postContext,
            'function' => $item['function'] ?? null,
            'class' => $item['class'] ?? null,
            // currently arguments wont be transmited due to large amount of informations based on base object
            //'args' => isset($item['args']) ? ArrayHelper::coverSensitiveValues($item['args'], $this->sensitiveKeys) : [],
        ], function ($value) {
            return !empty($value);
        });
    }
}
