<?php

namespace luya\admin\aws;

use luya\Exception;
use Curl\Curl;
use yii\helpers\Json;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Active Window created at 18.02.2016 13:22 on LUYA Version 1.0.0-beta5.
 * @todo handling multiple resources in gmaps
 */
class CoordinatesActiveWindow extends ActiveWindow
{
    public $module = '@admin';
    
    public $alias = 'Coordinates';
    
    public $icon = 'pin_drop';
    
    /**
     * @var string Register your maps application and enter your api key here
     * while configure the active window (https://console.developers.google.com).
     */
    public $mapsApiKey = null;
    
    /**
     * {@inheritDoc}
     * @see \admin\ngrest\base\ActiveWindow::init()
     */
    public function init()
    {
        if ($this->mapsApiKey === null) {
            throw new Exception('A google maps API key can not be null.');
        }
    }
    
    /**
     * Renders the index file of the ActiveWindow.
     *
     * @return string The render index file.
     */
    public function index()
    {
        return $this->render('index', [
            'id' => $this->itemId,
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
            return $this->sendError('Error while collecting data for your adresse. Check if you adress was correct and try again.');
        }
        
        $cords = $response['results'][0]['geometry']['location'];
        
        return $this->sendSuccess('We have found your location and pinned the marker on the submit.', ['cords' => $cords]);
    }
}
