<?php

namespace Fairy\Factory;

/**
 * Class ConfigAction
 * 获取全部配置
 * @package Fairy\Factory
 */
class ConfigAction extends Action
{
    public function getResult()
    {
        return json_encode($this->config);
    }
}
