<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.03.19
 * Time: 18:51
 */

namespace AppBundle\Repository;


use Guzzle\Http\Client;
use Helpers\EnvConfig;

abstract class AbstractRepository
{
    const METHOD_LIST = 'GET';
    const METHOD_CREATE = 'POST';
    const METHOD_EDIT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    protected $header = [
        'content-type' => 'application/json',
        'Accept' => 'application/json'
    ];

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var EnvConfig
     */
    protected $envConfig;

    public function __construct(EnvConfig $envConfig, Client $client)
    {
        $this->envConfig = $envConfig;
        $this->client = $client;
    }

    protected function generateUrl(string $path)
    {
        return sprintf('%s/%s/%s', $this->envConfig->getApiAddress(), $this->envConfig->getApiPrefix(), $path);
    }
}