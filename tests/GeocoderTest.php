<?php

namespace Tests;

use Geocoder\Geocoder;
use PHPUnit\Framework\TestCase;

class GeocoderTest extends TestCase
{
    /** @test */
    public function it_can_send_query_request()
    {
        $result = Geocoder::make()->geocode('Los Angeles');

        $this->assertNotEmpty($result->getRaw());
    }

    /** @test */
    public function it_can_retrieve_city_and_country()
    {
        $result = Geocoder::make()->geocode('New York');

        $this->assertEquals('New York', $result->first()->getCity());
        $this->assertEquals('United States', $result->first()->getCountry());
    }
}