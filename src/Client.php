<?php

namespace LibAnimeList;

use LibAnimeList\Exception\MissingCredentialsException;
use LibAnimeList\Model\Internal\Credentials;
use LibAnimeList\Model\MyAnimeList\Response\User;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class Client
 * @package LibAnimeList
 */
class Client
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * Client constructor.
     * @param Credentials|null $credentials
     */
    public function __construct(Credentials $credentials = null)
    {
        if ($credentials !== null) {
            $this->credentials = $credentials;
        }

        $encoders = array(new XmlEncoder());
        $normalizers = array(new ObjectNormalizer());

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @throws MissingCredentialsException
     *
     * @return bool
     */
    public function verifyCredentials()
    {
        if ($this->credentials === null) {
            throw new MissingCredentialsException();
        }

        $response = $this->doXmlRequest(
            self::METHOD_POST,
            'account/verify_credentials',
            [],
            User::class
        );

        if (!empty($response->getId())) {
            $this->credentials->setValid(true);
        }

        return $this->credentials->isValid();
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

        return (object)$this->serializer->deserialize($xml, $model, 'xml');
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

        curl_setopt($curlClient, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlClient, CURLOPT_SSL_VERIFYPEER, false);

        if ($this->credentials !== null) {
            curl_setopt($curlClient, CURLOPT_USERPWD, (string)$this->credentials);
            curl_setopt($curlClient, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        }

        $output = curl_exec($curlClient);

        curl_close($curlClient);

        return $output;
    }

    /**
     * @return Credentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }
}