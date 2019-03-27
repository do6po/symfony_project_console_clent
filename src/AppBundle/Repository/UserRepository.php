<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.03.19
 * Time: 19:06
 */

namespace AppBundle\Repository;


use AppBundle\Entity\User;
use AppBundle\Exceptions\NotFoundUserException;
use AppBundle\Exceptions\ResponseErrorException;
use AppBundle\Exceptions\ValidationErrorException;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Helpers\EnvConfig;
use Symfony\Component\HttpFoundation\Response;

class UserRepository
{
    const URL_USER_LIST = 'users';
    const URL_USER_CREATE = 'users';
    const URL_USER_EDIT = 'users';
    const URL_USER_DELETE = 'users';

    const METHOD_USER_LIST = 'GET';
    const METHOD_USER_CREATE = 'POST';
    const METHOD_USER_EDIT = 'PUT';
    const METHOD_USER_DELETE = 'DELETE';

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

    /**
     * @param User $user
     * @return array
     * @throws ResponseErrorException
     */
    public function add(User $user)
    {
        try {
            $response = $this->client
                ->createRequest(
                    self::METHOD_USER_CREATE,
                    $this->generateUrl(self::URL_USER_CREATE),
                    $this->header,
                    json_encode($user)
                )->send();

            if ($response->getStatusCode() === Response::HTTP_OK) {
                return $response->json();
            }

        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            if ($response->getStatusCode() === Response::HTTP_UNPROCESSABLE_ENTITY) {
                throw new ValidationErrorException($response);
            }
        }

        throw new ResponseErrorException(sprintf('Response error. Status code: %s', $response->getStatusCode()));
    }

    /**
     * @param User $user
     * @return array|bool|float|int|string
     * @throws ResponseErrorException
     */
    public function edit(User $user)
    {
        try {
            $url = $this->generateUrl(sprintf('%s/%s', self::URL_USER_EDIT, $user->id));
            $response = $this->client
                ->createRequest(
                    self::METHOD_USER_EDIT,
                    $url,
                    $this->header,
                    json_encode($user)
                )->send();

            if ($response->getStatusCode() === Response::HTTP_OK) {
                return $response->json();
            }

        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            if ($response->getStatusCode() === Response::HTTP_UNPROCESSABLE_ENTITY) {
                throw new ValidationErrorException($response);
            }
        }

        throw new ResponseErrorException(sprintf('Response error. Status code: %s', $response->getStatusCode()));
    }

    /**
     * @param User $user
     * @return array
     * @throws NotFoundUserException
     * @throws ResponseErrorException
     */
    public function delete(User $user)
    {
        try {
            $url = $this->generateUrl(
                sprintf('%s/%s', self::URL_USER_DELETE, $user->id)
            );

            $response = $this->client->createRequest(self::METHOD_USER_DELETE, $url, $this->header)->send();

            if ($response->getStatusCode() === Response::HTTP_OK) {
                return $response->json();
            }

        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            if ($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
                throw new NotFoundUserException('Not found user with id: ' . $user->id);
            }
        }

        throw new ResponseErrorException(sprintf('Response error. Status code: %s', $response->getStatusCode()));
    }

    protected function generateUrl(string $path)
    {
        return sprintf('%s/%s/%s', $this->envConfig->getApiAddress(), $this->envConfig->getApiPrefix(), $path);
    }
}