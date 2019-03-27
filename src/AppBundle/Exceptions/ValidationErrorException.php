<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.03.19
 * Time: 12:09
 */

namespace AppBundle\Exceptions;


use Guzzle\Http\Message\Response;
use Guzzle\Service\Exception\ValidationException;

class ValidationErrorException extends ValidationException
{
    public function __construct(Response $response)
    {
        $this->code = $response->getStatusCode();
        $this->setErrors($response->json());
    }
}