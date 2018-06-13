<?php

namespace Geocoder;

interface GeocoderClientInterface
{
    public function geocode($address, $region = null, $language = null): Response;
}