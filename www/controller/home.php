<?php

namespace Controller;

class Home extends \Controller
{
    public function __index(array $params=[])
    {
        return new \View('home', [
        ]);
    }
}
