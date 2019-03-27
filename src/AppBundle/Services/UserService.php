<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.03.19
 * Time: 18:54
 */

namespace AppBundle\Services;


use AppBundle\Entity\User;
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

    /**
     * @param User $user
     * @return array|bool|float|int|string
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    public function add(User $user)
    {
        return $this->userRepository->add($user);
    }
}