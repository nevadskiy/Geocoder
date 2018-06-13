<?php

namespace Geocoder;

class AddressProcessor
{
    private $raw;

    public function __construct($raw)
    {
        $this->raw = $raw;

//        $this->process();
    }

    public function getRaw()
    {
        return $this->raw;
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
        return $this->retrieveByTypeField('locality', 'long_name');
    }

    public function getCountry()
    {
        return $this->retrieveByTypeField('country', 'long_name');
    }

    public function parseLat()
    {
//        $lat =
    }
    protected function retrieveByTypeField($types, $field)
    {
        $filteredByType = array_filter($this->getRaw(), function ($item) use ($types) {
            return in_array($types, $item->types);
        });
        return reset($filteredByType)->{$field} ?? null;
    }
}