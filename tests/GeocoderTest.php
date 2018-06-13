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

    /** @test */
    public function it_can_retrieve_a_coordinates()
    {
        $result = Geocoder::make()->geocode('Las Vegas');

        $this->assertEquals(36, round($result->first()->getLat()));
        $this->assertEquals(-115, round($result->first()->getLng()));
    }

    /** @test */
    public function it_can_find_within_region()
    {
        $resultInUs = Geocoder::make()->geocode('KPI', 'us');
        $resultInUa = Geocoder::make()->geocode('KPI', 'ua');

        $this->assertEquals('United States', $resultInUs->first()->getCountry());
        $this->assertEquals('Ukraine', $resultInUa->first()->getCountry());
    }

    /** @test */
    public function it_can_find_depends_on_language()
    {
        $resultOnEnglish = Geocoder::make()->geocode('Kyiv', null, 'en');
        $resultOnRussian = Geocoder::make()->geocode('Kyiv', null, 'ru');

        $this->assertEquals('Ukraine', $resultOnEnglish->first()->getCountry());
        $this->assertEquals('Украина', $resultOnRussian->first()->getCountry());
    }

    /** @test */
    public function it_can_return_full_result()
    {
        $result = Geocoder::make()->geocode('Kyiv', null, 'en');

        $this->assertNotEmpty($result->first()->get());
        $this->assertEquals('Ukraine', $result->first()->get()['country']);
    }
}