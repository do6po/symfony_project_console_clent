<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.03.19
 * Time: 18:54
 */

namespace AppBundle\Services;


use AppBundle\Repository\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    public function all(): array
    {
        return $this->userRepository->all();
    }
}