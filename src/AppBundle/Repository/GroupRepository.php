<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.03.19
 * Time: 18:49
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Group;
use AppBundle\Exceptions\NotFoundEntityException;
use AppBundle\Exceptions\ResponseErrorException;
use AppBundle\Exceptions\ValidationErrorException;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Response;

class GroupRepository extends AbstractRepository
{
    const URL_GROUP_LIST = 'groups';
    const URL_GROUP_DELETE = 'groups';
    const URL_GROUP_CREATE = 'groups';

    /**
     * @return array
     * @throws ResponseErrorException
     */
    public function all(): array
    {
        $url = $this->generateUrl(self::URL_GROUP_LIST);

        $response = $this->client
            ->createRequest(self::METHOD_LIST, $url)
            ->send();

        if ($response->getStatusCode() === Response::HTTP_OK) {
            return $response->json();
        }

        $this->throwResponseErrorException($response->getStatusCode());
    }

    /**
     * @param Group $group
     * @return array|bool|float|int|string
     * @throws ResponseErrorException
     */
    public function add(Group $group)
    {
        try {
            $response = $this->client
                ->createRequest(
                    self::METHOD_CREATE,
                    $this->generateUrl(self::URL_GROUP_CREATE),
                    $this->header,
                    json_encode($group)
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
     * @param Group $group
     * @return array
     * @throws NotFoundEntityException
     * @throws ResponseErrorException
     */
    public function delete(Group $group)
    {
        try {
            $url = $this->generateUrl(
                sprintf('%s/%s', self::URL_GROUP_DELETE, $group->id)
            );

            $response = $this->client->createRequest(self::METHOD_DELETE, $url, $this->header)->send();

            if ($response->getStatusCode() === Response::HTTP_OK) {
                return $response->json();
            }

        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            if ($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
                throw new NotFoundEntityException('Not found group with id: ' . $group->id);
            }
        }

        $this->throwResponseErrorException($response->getStatusCode());
    }
}