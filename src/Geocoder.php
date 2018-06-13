<?php

namespace Geocoder;

use GuzzleHttp\Client;

class Geocoder
{
    public $client;

    public function __construct()
    {
        $this->client = new GeocoderClient(new Client(), 'AIzaSyAIhFuptEQOOSwCWCA7BLBmahJe1Y4WTPM');
    }

    public static function make()
    {
        return new static();
    }

    public function geocode($address, $region = null, $language = null)
    {
        return $this->client->geocode($address, $region, $language);
    }

    public function reverse()
    {
        // @TODO: reverse geocoding...
    }
}