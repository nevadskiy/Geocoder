<?php

namespace Geocoder;

class AddressProcessor
{
    private $raw;

    protected $address = null;

    private $fields = [
        'city', 'country', 'lat', 'lng'
    ];


    public function __construct($raw)
    {
        $this->raw = $raw;
    }

    public function getRaw()
    {
        return $this->raw;
    }


    // @TODO: cache all results after call method.
    // @TODO: processMethods for retrieving
    // @TODO: magic getters for simple call

    public function get()
    {
        return array_reduce($this->fields, function ($result, $field) {
            $methodName = 'get' . ucfirst($field);
            if (!method_exists($this, $methodName)) {
                throw new GeocoderExpection("Getter for {$field} is not presented");
            }
            $result[$field] = $this->$methodName();

            return $result;
        }, []);
    }

//    public function parse()
//    {
//        foreach ($this->parsedResponse->getFields() as $field) {
//            $methodName = 'parse' . ucfirst($field);
//            if (!method_exists($this, $methodName)) {
//                throw new \Exception('No parser presented for ' . $field . ' property');
//            }
//            $this->{$methodName}();
//        }
//        return $this->parsedResponse;
//    }

    public function getCity()
    {
        return $this->retrieveByTypeField('address_components', 'locality', 'long_name');
    }

    public function getCountry()
    {
        return $this->retrieveByTypeField('address_components', 'country', 'long_name');
    }

    public function getLat()
    {
        return $this->getRaw()->geometry->location->lat ?? null;
    }

    public function getLng()
    {
        return $this->getRaw()->geometry->location->lng ?? null;

    }

    protected function retrieveByTypeField($component, $type, $field)
    {
        $componentArray = $this->getRaw()->{$component} ?? null;
        if (!$componentArray) {
            return null;
        }

        $filteredByType = array_filter($componentArray, function ($item) use ($type) {
            return in_array($type, $item->types);
        });

        return reset($filteredByType)->{$field} ?? null;
    }
}