<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.03.19
 * Time: 18:49
 */

namespace AppBundle\Repository;


use AppBundle\Exceptions\ResponseErrorException;
use Symfony\Component\HttpFoundation\Response;

class GroupRepository extends AbstractRepository
{
    const URL_GROUP_LIST = 'groups';

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

}