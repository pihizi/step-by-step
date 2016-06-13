<?php

namespace Controller;

class Help extends \Controller
{
    public function __index(array $params=[])
    {
        return new \View('help', [
            'aa'=> 'help me'
        ]);
    }
}
