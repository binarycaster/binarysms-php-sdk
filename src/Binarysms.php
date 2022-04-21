<?php

namespace Binarycaster\Binarysms;


class Binarysms
{
    public $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param $name
     *
     * @return  string
     */
    public function sayHello($name)
    {
        return $this->config->get('greeting') . ' ' . $name;
    }

    public function sayBye($name)
    {
        return $this->config->get('greeting') . ' ' . $name;
    }

}
