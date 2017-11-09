<?php

namespace LibAnimeList;
use LibAnimeList\Model\BaseModel;
use LibAnimeList\Model\VerifyCredentialsResponseModel;

/**
 * Class AnimeListClient
 * @package LibAnimeList
 */
class AnimeListClient
{
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';

    /**
     * @var AnimeListCredentials|null
     */
    private $credentials;

    /**
     * AnimeListClient constructor.
     * @param null $credentials
     */
    public function __construct($credentials = null)
    {
        if ($credentials !== null) {
            $this->credentials = $credentials;
        }
    }

    public function verifyCredentials()
    {
        if ($this->credentials === null) {
            throw new \DomainException('Could not verify null credentials.');
        }

        $result = $this->doXmlRequest(
            self::METHOD_GET,
            'account/verify_credentials',
            [],
            VerifyCredentialsResponseModel::class
        );

        return !$result->hasMisser('id');
    }

    /**
     * @param $username
     * @param $password
     * @return AnimeListCredentials
     */
    public static function createCredentials($username, $password)
    {
        return new AnimeListCredentials($username, $password);
    }

    /**
     * @param $method
     * @param $endpoint
     * @param $parameters
     * @param $model
     *
     * @return mixed
     */
    private function doXmlRequest($method, $endpoint, $parameters, $model)
    {
        $xml = $this->sendCurlRequest($method, $endpoint, $parameters);

        /**
         * @var $model BaseModel
         */
        $model = new $model();
        $model->fromXml($xml);

        return $model;
    }

    /**
     * @param $method
     * @param $endpoint
     * @param array $parameters
     */
    private function sendCurlRequest($method, $endpoint, $parameters = [])
    {
        $url = sprintf('https://myanimelist.net/api/%s.xml', $endpoint);

        $curlClient = curl_init();

        curl_setopt($curlClient, CURLOPT_URL, $url);
        curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, true);

        if ($method === self::METHOD_POST) {
            curl_setopt($curlClient, CURLOPT_POST, 1);
        }

        curl_setopt($curlClient, CURLOPT_POSTFIELDS, http_build_query($parameters));

        if ($this->credentials !== null) {
            curl_setopt($curlClient, CURLOPT_USERPWD, (string)$this->credentials);
            curl_setopt($curlClient, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        }

        $output = curl_exec($curlClient);

        curl_close($curlClient);

        return $output;
    }
}