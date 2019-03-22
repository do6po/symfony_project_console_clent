<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 22.03.19
 * Time: 18:53
 */

namespace Tests;


use Symfony\Component\DependencyInjection\ContainerInterface;

class KernelTestCase extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setUp()
    {
        parent::setUp();

        $this->container = self::bootKernel()->getContainer();
    }
}