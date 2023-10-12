<?php

namespace Unipile;


class UnipileSDKException extends \Exception
{
}


class UnipileSDK
{
    private $baseUri;
    private $httpClient;
    private $token;

    public function __construct($baseUri, $token = null)
    {
        $this->baseUri = $baseUri;
        $this->httpClient = new \GuzzleHttp\Client(['base_uri' => $baseUri]);
        $this->token = $token;
    }
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        $className = "Unipile\\{$name}";
        if (class_exists($className)) {
            return new $className($this->baseUri, $this->token,  $this->httpClient);
        }

        return null;
    }
    protected function handleAPIError($response)
    {
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);

        if ($statusCode >= 400) {
            $errorMessage = $responseBody['error'] ?? 'Unknown error';

            switch ($statusCode) {
                case 401:
                    throw new UnipileSDKException("Unauthorized: $errorMessage", $statusCode);
                case 404:
                    throw new UnipileSDKException("Route unknow: $errorMessage", $statusCode);
                case 500:
                    throw new UnipileSDKException("Internal Server Error: $errorMessage", $statusCode);
                case 503:
                    throw new UnipileSDKException("Service Unavailable: $errorMessage", $statusCode);
                case 504:
                    throw new UnipileSDKException("Gateway Timeout: $errorMessage", $statusCode);
                default:
                    throw new UnipileSDKException("API Error: $errorMessage", $statusCode);
            }
        }
    }
}
