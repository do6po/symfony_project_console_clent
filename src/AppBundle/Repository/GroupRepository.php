<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.03.19
 * Time: 18:49
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use AppBundle\Exceptions\NotFoundEntityException;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Response;

class GroupRepository extends AbstractRepository
{
    const URL_TO_LIST = 'groups';
    const URL_TO_CREATE = 'groups';
    const URL_TO_EDIT = 'groups';
    const URL_TO_DELETE = 'groups';

    const METHOD_ADD_TO_GROUP = 'PUT';
    const METHOD_DELETE_FROM_GROUP = 'DELETE';

    /**
     * @param Group $group
     * @return array
     * @throws NotFoundEntityException
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    public function userList(Group $group): array
    {
        $url = $this->generateUrl(sprintf('%s/%s', static::URL_TO_LIST, $group->id));

        try {
            $response = $this->client
                ->createRequest(static::METHOD_LIST, $url)
                ->send();

            if ($response->getStatusCode() === Response::HTTP_OK) {
                return $response->json();
            }

        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            if ($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
                throw new NotFoundEntityException(sprintf('Not found %s with id: %s', $group->entityName(), $group->id));
            }
        }

        $this->throwResponseErrorException($response->getStatusCode());
    }

    /**
     * @param Group $group
     * @param User $user
     * @return array|bool|float|int|string
     * @throws NotFoundEntityException
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    public function addUserToGroup(Group $group, User $user)
    {
        $url = $this->generateUrl(sprintf('%s/%s/add', static::URL_TO_EDIT, $group->id));

        try {
            $response = $this->client
                ->createRequest(
                    static::METHOD_ADD_TO_GROUP,
                    $url,
                    $this->header,
                    json_encode(['user_id' => $user->id])
                )->send();

            if ($response->getStatusCode() === Response::HTTP_OK) {
                return $response->json();
            }

        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            if ($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
                throw new NotFoundEntityException($response->json()['error']);
            }
        }

        $this->throwResponseErrorException($response->getStatusCode());
    }

    /**
     * @param $group
     * @param $user
     * @return array|bool|float|int|string
     * @throws NotFoundEntityException
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    public function delUserFromGroup($group, $user)
    {
        $url = $this->generateUrl(sprintf('%s/%s/del', static::URL_TO_DELETE, $group->id));

        try {
            $response = $this->client
                ->createRequest(
                    static::METHOD_DELETE_FROM_GROUP,
                    $url,
                    $this->header,
                    json_encode(['user_id' => $user->id])
                )->send();

            if ($response->getStatusCode() === Response::HTTP_OK) {
                return $response->json();
            }

        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            if ($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
                throw new NotFoundEntityException($response->json()['error']);
            }
        }

        $this->throwResponseErrorException($response->getStatusCode());
    }
}