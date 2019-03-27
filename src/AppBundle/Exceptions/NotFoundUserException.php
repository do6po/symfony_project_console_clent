<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.03.19
 * Time: 18:15
 */

namespace AppBundle\Exceptions;


class NotFoundUserException extends \Exception
{
    protected $code = 404;
}