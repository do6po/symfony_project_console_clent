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
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Response;

class GroupRepository extends AbstractRepository
{
    const URL_TO_LIST = 'groups';
    const URL_TO_CREATE = 'groups';
    const URL_TO_EDIT = 'groups';
    const URL_TO_DELETE = 'groups';

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
}