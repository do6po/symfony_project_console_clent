<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 21.03.19
 * Time: 18:24
 */

namespace Helpers;

use Symfony\Component\Dotenv\Dotenv;

class EnvConfig
{
    protected $environment;

    public function __construct(string $environment = 'prod')
    {
        $this->environment = $environment;

        $this->init();
    }


    protected function init()
    {
        $dotenv = new Dotenv();

        if ($this->environment === 'prod') {
            $path = "/../../.env";
        } else {
            $path = "/../../.env.tests";
        }

        $dotenv->load(__DIR__ . $path);
    }

    public function getApiAddress(): string
    {
        return getenv('API_ADDRESS');
    }

    public function getApiPrefix(): string
    {
        return getenv('API_PREFIX');
    }
}