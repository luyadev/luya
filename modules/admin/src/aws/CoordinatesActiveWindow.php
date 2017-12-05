<?php

namespace luya\admin\aws;

use luya\Exception;
use Curl\Curl;
use yii\helpers\Json;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Coordinates Collector.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class CoordinatesActiveWindow extends ActiveWindow
{
    /**
     * @var string The name of the module where the active windows is located in order to finde the view path.
     */
    public $module = '@admin';
   
    /**
     * @var string Register your maps application and enter your api key here
     * while configure the active window (https://console.developers.google.com).
     */
    public $mapsApiKey;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->mapsApiKey === null) {
            throw new Exception('A google maps API key can not be null.');
        }
    }
    
    /**
     * @inheritdoc
     */
    public function defaultLabel()
    {
        return 'Coordinates';
    }
    
    /**
     * @inheritdoc
     */
    public function defaultIcon()
    {
        return 'pin_drop';
    }
    
    /**
     * Renders the index file of the ActiveWindow.
     *
     * @return string The render index file.
     */
    public function index()
    {
        return $this->render('index', [
            'mapsApiKey' => $this->mapsApiKey,
        ]);
    }
    
    public function callbackGetCoordinates($address)
    {
        $curl = new Curl();
        $curl->get('https://maps.googleapis.com/maps/api/geocode/json?', ['key' => $this->mapsApiKey, 'address' => $address]);
        
        if ($curl->error) {
            return $this->sendError('Error while getting data from google maps API: ' . $curl->error_message);
        }
        
        $response = Json::decode($curl->response);
        
        if (!isset($response['results']) || !isset($response['results'][0])) {
            return $this->sendError('Error while collecting data for your address. Check if you address was correct and try again.');
        }
        
        $cords = $response['results'][0]['geometry']['location'];
        
        return $this->sendSuccess('We have found your location and pinned the marker on the submit.', ['cords' => $cords]);
    }
}
