<?php

namespace luya\web;

use Yii;

/**
 * Request Component.
 *
 * Extending the {{yii\web\Request}} class by predefine values and add ability to verify whether the request is in admin context or not.
 *
 * @property boolean $isAdmin Whether the request is admin or not.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Request extends \yii\web\Request
{
    /**
     * @var boolean Force web request to enable unit tests with simulated web requests
     */
    public $forceWebRequest = false;

    /**
     * @var string The validation cookie for cookies, should be overwritten in your configuration.
     *
     * The cookie validation key is generated randomly or by any new release but should be overriten in your config.
     *
     * http://randomkeygen.com using a 504-bit WPA Key
     */
    public $cookieValidationKey = '(`1gq(|TI2Zxx7zZH<Zk052a9a$@l2EtD9wT`lkTO@7uy{cPaJt4y70mxh4q(3';
    
    /**
     * @var array A list of default available parsers.
     */
    public $parsers = [
        'application/json' => 'yii\web\JsonParser',
    ];
    
    private $_isAdmin = null;
    
    /**
     * Setter method to force isAdmin request.
     *
     * @param boolean $state Whether its an admin request or not
     */
    public function setIsAdmin($state)
    {
        $this->_isAdmin = $state;
    }

    /**
     * Getter method resolves the current url request and check if admin context.
     *
     * This is mostly used in order to bootstrap more modules and application logic in admin context.
     *
     * @return boolean If the current request is in admin context return value is true, otherwise false.
     */
    public function getIsAdmin()
    {
        if ($this->_isAdmin === null) {
            if ($this->getIsConsoleRequest() && !$this->forceWebRequest) {
                $this->_isAdmin = false;
            } else {
                $resolver = Yii::$app->composition->getResolvedPathInfo($this);
                $pathInfo = $resolver['route'];
                $parts = explode('/', $pathInfo);
                $first = reset($parts);
                
                if (preg_match('/admin/i', $first, $results)) {
                    $this->_isAdmin = true;
                } else {
                    $this->_isAdmin = false;
                }
            }
        }
        
        return $this->_isAdmin;
    }
}
