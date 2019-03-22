<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 21.03.19
 * Time: 17:46
 */

namespace Tests\Helpers;


use Helpers\EnvConfig;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class EnvConfigTest extends TestCase
{
    /**
     * @var EnvConfig
     */
    protected $env;


    public function setUp()
    {
        parent::setUp();

        $this->env = new EnvConfig();
    }

    public function testGetApiAddress()
    {
        $this->assertEquals('http://localhost', $this->env->getApiAddress());
    }
}