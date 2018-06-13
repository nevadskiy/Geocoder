<?php

namespace Geocoder;

use GuzzleHttp\ClientInterface;

class GeocoderClient
{
    // Response about limit queries amount
    const ERROR_OVER_LIMIT = 'OVER_QUERY_LIMIT';

    // Response about denied request
    const ERROR_REQUEST_DENIED = 'REQUEST_DENIED';

    // Default API response language
    const DEFAULT_LANGUAGE = 'en';

    /**
     * Http client.
     *
     * @var ClientInterface
     */
    private $httpClient;

    public function __construct(ClientInterface $httpClient, $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    public function geocode($address, $region = null, $language = null): Response
    {
        $request = $this->request($address, $region, $language);

        return $this->getResponse($request);
    }

    private function getEndpointUrl()
    {
        return 'https://maps.googleapis.com/maps/api/geocode/json?&key=' . $this->apiKey;
    }

    private function getParams()
    {
        return ['address', 'region', 'language'];
    }

    private function buildRequestString($address, $region, $language)
    {
        $queryString = $this->getEndpointUrl();

        foreach ($this->getParams() as $param) {
            if ($paramValue = $$param) {
                $queryString .= '&' . $param . '=' . $paramValue;
            }
        }

        return $queryString;
    }

    private function getResponse($request)
    {
        return $this->parseResponse(json_decode($request->getBody()->getContents() ?? null));
    }

    private function parseResponse($response)
    {
        return new Response($response);
    }

    public function sendQuery($query)
    {
        try {
            $request = $this->httpClient->request('get', $query);
        } catch (\Exception $e) {

            // TODO: Check for limits query and deny requesting

            // \Log::error($e->getMessage());
        }

        return $request ?? null;
    }

    private function request($address, $region = null, $language = null)
    {
        return $this->sendQuery($this->buildRequestString($address, $region, $language));
    }
}