<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.03.19
 * Time: 19:06
 */

namespace AppBundle\Repository;


use AppBundle\Entity\User;
use AppBundle\Exceptions\NotFoundEntityException;
use AppBundle\Exceptions\ResponseErrorException;
use AppBundle\Exceptions\ValidationErrorException;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Response;

class UserRepository extends AbstractRepository
{
    const URL_USER_LIST = 'users';
    const URL_USER_CREATE = 'users';
    const URL_USER_EDIT = 'users';
    const URL_USER_DELETE = 'users';

    /**
     * @return array
     * @throws ResponseErrorException
     */
    public function all(): array
    {
        $url = $this->generateUrl(self::URL_USER_LIST);
        $response = $this->client
            ->createRequest(self::METHOD_LIST, $url)
            ->send();

        if ($response->getStatusCode() === Response::HTTP_OK) {
            return $response->json();
        }

        $this->throwResponseErrorException($response->getStatusCode());
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
                    self::METHOD_CREATE,
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

        $this->throwResponseErrorException($response->getStatusCode());
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
                    self::METHOD_EDIT,
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

        $this->throwResponseErrorException($response->getStatusCode());
    }

    /**
     * @param User $user
     * @return array
     * @throws NotFoundEntityException
     * @throws ResponseErrorException
     */
    public function delete(User $user)
    {
        try {
            $url = $this->generateUrl(
                sprintf('%s/%s', self::URL_USER_DELETE, $user->id)
            );

            $response = $this->client->createRequest(self::METHOD_DELETE, $url, $this->header)->send();

            if ($response->getStatusCode() === Response::HTTP_OK) {
                return $response->json();
            }

        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            if ($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
                throw new NotFoundEntityException('Not found user with id: ' . $user->id);
            }
        }

        $this->throwResponseErrorException($response->getStatusCode());
    }
}