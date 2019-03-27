<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 26.03.19
 * Time: 17:45
 */

namespace AppBundle\Command;


use AppBundle\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class BasicAbstractCommand extends ContainerAwareCommand
{
    /**
     * @var UserService
     */
    protected $userServices;

    public function __construct(UserService $userServices, ?string $name = null)
    {
        parent::__construct($name);

        $this->userServices = $userServices;
    }
}