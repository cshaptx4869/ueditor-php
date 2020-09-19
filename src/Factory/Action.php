<?php


namespace Fairy\Factory;


abstract class Action
{
    protected $config;

    public function __construct()
    {
        $this->config = include_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config.php');
    }

    abstract public function getResult();
}
