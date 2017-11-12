<?php

namespace App\Controllers;

class Controller
{
    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __get($proprety)
    {
        if($this->container->{$proprety}){
            return $this->container->{$proprety};
        }
    }
}
