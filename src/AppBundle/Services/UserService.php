<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.03.19
 * Time: 18:54
 */

namespace AppBundle\Services;


use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use AppBundle\Repository\GroupRepository;
use AppBundle\Repository\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(
        UserRepository $userRepository,
        GroupRepository $groupRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
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
     * @return array
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    public function add(User $user): array
    {
        return $this->userRepository->add($user);
    }

    /**
     * @param User $user
     * @return array
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    public function edit(User $user): array
    {
        return $this->userRepository->edit($user);
    }

    /**
     * @param User $user
     * @return array
     * @throws \AppBundle\Exceptions\NotFoundEntityException
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    public function delete(User $user): array
    {
        return $this->userRepository->delete($user);
    }

    /**
     * @return array
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    public function groupAll()
    {
        return $this->groupRepository->all();
    }

    /**
     * @param $group
     * @return array
     * @throws \AppBundle\Exceptions\NotFoundEntityException
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    public function deleteGroup(Group $group)
    {
        return $this->groupRepository->delete($group);
    }

    /**
     * @param Group $group
     * @return array|bool|float|int|string
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    public function addGroup(Group $group)
    {
        return $this->groupRepository->add($group);
    }
}