<?php

namespace Geocoder;

class Response
{
    protected $raw;

    public function __construct($raw = null)
    {
        $this->raw = $raw;
    }

    public function first()
    {
        return new AddressProcessor($this->getRaw()->results[0] ?? null);
    }

    public function getRaw()
    {
        return $this->raw;
    }
}