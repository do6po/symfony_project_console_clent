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
    public function __construct()
    {
        $this->init();
    }


    protected function init()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . "/../../.env");
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