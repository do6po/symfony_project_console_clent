<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 21.03.19
 * Time: 17:46
 */

namespace Tests\Helpers;


use Helpers\EnvConfig;
use Tests\KernelTestCase;

class EnvConfigTest extends KernelTestCase
{
    /**
     * @var EnvConfig
     */
    protected $env;

    public function setUp()
    {
        parent::setUp();
        $this->env = $this->container->get('env_config');
    }

    public function testGetApiAddress()
    {
        $this->assertEquals('http://localhost', $this->env->getApiAddress());
    }
}