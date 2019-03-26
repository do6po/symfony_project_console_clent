<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.03.19
 * Time: 19:06
 */

namespace AppBundle\Repository;


use AppBundle\Exceptions\ResponseErrorException;
use Guzzle\Http\Client;
use Helpers\EnvConfig;
use Symfony\Component\HttpFoundation\Response;

class UserRepository
{
    const URL_USER_LIST = 'users';

    const METHOD_USER_LIST = 'GET';

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

    /**
     * @return array
     * @throws ResponseErrorException
     */
    public function all(): array
    {
        $url = $this->generateUrl(self::URL_USER_LIST);

        $response = $this->client
            ->createRequest(self::METHOD_USER_LIST, $url)
            ->send();

        if ($response->getStatusCode() === Response::HTTP_OK) {
            return $response->json();
        }

        throw new ResponseErrorException(sprintf('Response error. Status code: %s', $response->getStatusCode()));
    }

    protected function generateUrl(string $path)
    {
        return sprintf('%s/%s/%s', $this->envConfig->getApiAddress(), $this->envConfig->getApiPrefix(), $path);
    }
}