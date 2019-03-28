<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.03.19
 * Time: 18:51
 */

namespace AppBundle\Repository;


use AppBundle\Entity\AbstractEntity;
use AppBundle\Exceptions\NotFoundEntityException;
use AppBundle\Exceptions\ResponseErrorException;
use AppBundle\Exceptions\ValidationErrorException;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Helpers\EnvConfig;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractRepository
{
    const METHOD_LIST = 'GET';
    const METHOD_CREATE = 'POST';
    const METHOD_EDIT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    const URL_TO_LIST = 'url';
    const URL_TO_CREATE = 'url';
    const URL_TO_EDIT = 'url';
    const URL_TO_DELETE = 'url';

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

    /**
     * @return array
     * @throws ResponseErrorException
     */
    public function all(): array
    {
        $url = $this->generateUrl(static::URL_TO_LIST);
        $response = $this->client
            ->createRequest(static::METHOD_LIST, $url)
            ->send();

        if ($response->getStatusCode() === Response::HTTP_OK) {
            return $response->json();
        }

        $this->throwResponseErrorException($response->getStatusCode());
    }

    /**
     * @param AbstractEntity $entity
     * @return array|bool|float|int|string
     * @throws ResponseErrorException
     */
    public function add(AbstractEntity $entity)
    {
        try {
            $response = $this->client
                ->createRequest(
                    static::METHOD_CREATE,
                    $this->generateUrl(static::URL_TO_CREATE),
                    $this->header,
                    json_encode($entity)
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

        $this->throwResponseErrorException($response->getStatusCode());
    }

    /**
     * @param AbstractEntity $entity
     * @return array|bool|float|int|string
     * @throws ResponseErrorException
     */
    public function edit(AbstractEntity $entity)
    {
        try {
            $url = $this->generateUrl(sprintf('%s/%s', static::URL_TO_EDIT, $entity->id));
            $response = $this->client
                ->createRequest(
                    static::METHOD_EDIT,
                    $url,
                    $this->header,
                    json_encode($entity)
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

        $this->throwResponseErrorException($response->getStatusCode());
    }

    /**
     * @param AbstractEntity $entity
     * @return array|bool|float|int|string
     * @throws NotFoundEntityException
     * @throws ResponseErrorException
     */
    public function delete(AbstractEntity $entity)
    {
        try {
            $url = $this->generateUrl(
                sprintf('%s/%s', static::URL_TO_DELETE, $entity->id)
            );

            $response = $this->client->createRequest(static::METHOD_DELETE, $url, $this->header)->send();

            if ($response->getStatusCode() === Response::HTTP_OK) {
                return $response->json();
            }

        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            if ($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
                throw new NotFoundEntityException(sprintf('Not found %s with id: %s', $entity->entityName(), $entity->id));
            }
        }

        $this->throwResponseErrorException($response->getStatusCode());
    }

    /**
     * @param $statusCode
     * @throws ResponseErrorException
     */
    protected function throwResponseErrorException($statusCode): void
    {
        throw new ResponseErrorException(sprintf('Response error. Status code: %s', $statusCode));
    }
}